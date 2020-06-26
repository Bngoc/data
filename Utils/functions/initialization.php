<?php

//Since 2.0.3 crossplatform path generator
function cn_path_construct()
{
    $args = array();
    $arg_list = func_get_args();

    foreach ($arg_list as $varg) {
        if ($varg !== '') {
            $args[] = $varg;
        }
    }

    return implode(DIRECTORY_SEPARATOR, $args) . DIRECTORY_SEPARATOR;
}

// Since 2.0: Get option from #CFG or [%site][<opt_name>]
// Usage: #level1/level2/.../levelN or 'option_name' from %site
function getOption($opt_name = '', $var_name = '')
{
    $cfg = getMemcache('config');

    if ($opt_name === '') {
        return $cfg;
    }
    if ($opt_name[0] == '#') {
        $cfn = separateString(substr($opt_name, 1), '/');
        foreach ($cfn as $id) {
            if (isset($cfg[$id])) {
                $cfg = $cfg[$id];
            } else {
                $cfg = array();
                break;
            }
        }

        return $cfg;
    } else if ($opt_name[0] == '@') {
        if (!empty($var_name)) {

            $opt_name_ = substr($opt_name, 1);

            return isset($cfg[$opt_name_][$var_name]) ? $cfg[$opt_name_][$var_name] : false;
        } else {
            //exit();
            $opt_name_arr = separateString(substr($opt_name, 1), '/');
            foreach ($opt_name_arr as $id) {
                if (isset($cfg[$id])) {
                    $cfg = $cfg[$id];
                } else {
                    $cfg = array();
                    break;
                }
            }

            return $cfg;
        }
    } else {
        return isset($cfg['%site'][$opt_name]) ? $cfg['%site'][$opt_name] : false;
        //else
        //return isset($cfg['#'.$var_name_][$opt_name]) ? $cfg['#'.$var_name_][$opt_name] : false;
    }
}

// Since 1.5.0
// Separate string to array: imporved "explode" function
function separateString($separated_string, $seps = ',')
{
    if (strlen($separated_string) == 0) {
        return array();
    }
    $ss = explode($seps, $separated_string);
    return $ss;
}


function ctime()
{
    date_default_timezone_set("UTC");
    return (time() + 3600 * getOption('date_adjust'));
}

// Since 1.5.0: Add hook to system
function add_hook($hook, $func)
{
    global $_HOOKS;

    $prior = 1;
    if ($hook[0] == '+') $hook = substr($hook, 1);
    if ($hook[0] == '-') {
        $prior = 0;
        $hook = substr($hook, 1);
    }

    if (!isset($_HOOKS[$hook])) $_HOOKS[$hook] = array();

    // priority (+/-)
    if ($prior) array_unshift($_HOOKS[$hook], $func); else $_HOOKS[$hook][] = $func;
}

// Since 1.5.0: Cascade Hooks
function hook($hook, $args = null)
{
    global $_HOOKS;

    // Plugin hooks
    if (!empty($_HOOKS[$hook]) && is_array($_HOOKS[$hook])) {
        foreach ($_HOOKS[$hook] as $hookfunc) {
            if ($hookfunc[0] == '*') {
                $_args = call_user_func_array(substr($hookfunc, 1), $args);
            } else {
                $_args = call_user_func($hookfunc, $args);
            }

            if (!is_null($_args)) {
                $args = $_args;
            }
        }
    }
    return $args;
}

// Since 2.0: Extended assign
function cn_assign()
{
    $args = func_get_args();
    $keys = explode(',', array_shift($args));

    foreach ($args as $id => $arg) {
        // Simple assign
        if (isset($keys[$id])) {
            $KEY = trim($keys[$id]);
            $GLOBALS[$KEY] = $arg;
        } else {
            // Inline assign
            list($k, $v) = explode('=', $arg, 2);
            $GLOBALS[$k] = $v;
        }
    }
}

// Since 1.5.3
function GET($var, $method = 'GETPOST')
{
    $result = array();
    $vars = separateString($var);
    $method = strtoupper($method);

    if ($method == 'GETPOST') {
        $methods = array('GET', 'POST');
    } elseif ($method == 'POSTGET') {
        $methods = array('POST', 'GET');
    } elseif ($method == 'GPG') {
        $methods = array('POST', 'GET', 'GLOB');
    } else {
        $methods = separateString($method);
    }

    foreach ($vars as $var) {
        $var = trim($var);
        $value = null;

        foreach ($methods as $method) {
            if ($method == 'GLOB' && isset($GLOBALS[$var])) {
                $value = $GLOBALS[$var];
            } elseif ($method == 'POST' && isset($_POST[$var])) {
                $value = $_POST[$var];
            } elseif ($method == 'GET' && isset($_GET[$var])) {
                $value = $_GET[$var];
            } elseif ($method == 'POSTGET') {
                if (isset($_POST[$var])) {
                    $value = $_POST[$var];
                } elseif (isset($_GET[$var])) {
                    $value = $_GET[$var];
                }
            } elseif ($method == 'GETPOST') {
                if (isset($_GET[$var])) {
                    $value = $_GET[$var];
                } elseif (isset($_POST[$var])) {
                    $value = $_POST[$var];
                }
            } elseif ($method == 'REQUEST' && isset($_REQUEST[$var])) {
                $value = $_REQUEST[$var];
            } elseif ($method == 'COOKIE' && isset($_COOKIE[$var])) {
                $value = $_COOKIE[$var];
            }

            if (!is_null($value)) {
                break;
            }
        }

        $result[] = $value;
    }
    return $result;
}

// Since 2.0: Extended extract
function _GL($v)
{
    $vs = explode(',', $v);
    $result = array();
    foreach ($vs as $vc) {
        $el = explode(':', $vc, 2);
        $vc = isset($el[0]) ? $el[0] : false;
        $func = isset($el[1]) ? $el[1] : false;
        $var = false;
        if ($vc) $var = isset($GLOBALS[trim($vc)]) ? $GLOBALS[trim($vc)] : false;
        if ($func) $var = call_user_func($func, $var);
        $result[] = $var;
    }

    return $result;
}

// Since 1.5.3: Set cache variable
function setMemcache($name, $var)
{
    global $_CN_SESS_CACHE;
    $_CN_SESS_CACHE[$name] = $var;
}

// Since 1.5.3: Get variable from cache
function getMemcache($name)
{
    global $_CN_SESS_CACHE;
    return $name && isset($_CN_SESS_CACHE[$name]) ? $_CN_SESS_CACHE[$name] : false;
}

// Since 2.0: Add message
function cn_throw_message($msg, $area = 'n')
{
    $es = getMemcache('msg:stor');

    if (!isset($es[$area])) $es[$area] = array();
    $es[$area][] = i18n($msg);

    setMemcache('msg:stor', $es);

    return false;
}

function i18n()
{
    $i8 = getMemcache('#i18n');
    $va = func_get_args();
    $ft = array_shift($va);

    if (is_array($ft)) list($ft, $sph) = $ft; else $sph = '';
    $sph .= hi18n($ft);

    // match soundex found
    if (isset($i8[$sph]))
        $ft = UTF8ToEntities($i8[$sph]);

    // Replace placeholders
    foreach ($va as $id => $vs)
        $ft = str_replace("%" . ($id + 1), $vs, $ft);

    return $ft;
}

function UTF8ToEntities($string)
{
    if (is_array($string)) {
        return $string;
    }

    // @Note May be deprecated in next versions
    $HTML_SPECIAL_CHARS_UTF8 = array
    (
        'c2a1' => '&iexcl;',
        'c2a2' => '&cent;',
        'c2a3' => '&pound;',
        'c2a4' => '&curren;',
        'c2a5' => '&yen;',
        'c2a6' => '&brvbar;',
        'c2a7' => '&sect;',
        'c2a8' => '&uml;',
        'c2a9' => '&copy;',
        'c2aa' => '&ordf;',
        'c2ab' => '&laquo;',
        'c2bb' => '&raquo;',
        'c2ac' => '&not;',
        'c2ae' => '&reg;',
        'c2af' => '&macr;',
        'c2b0' => '&deg;',
        'c2ba' => '&ordm;',
        'c2b1' => '&plusmn;',
        'c2b9' => '&sup1;',
        'c2b2' => '&sup2;',
        'c2b3' => '&sup3;',
        'c2b4' => '&acute;',
        'c2b7' => '&middot;',
        'c2b8' => '&cedil;',
        'c2bc' => '&frac14;',
        'c2bd' => '&frac12;',
        'c2be' => '&frac34;',
        'c2bf' => '&iquest;',
        'c380' => '&Agrave;',
        'c381' => '&Aacute;',
        'c382' => '&Acirc;',
        'c383' => '&Atilde;',
        'c384' => '&Auml;',
        'c385' => '&Aring;',
        'c386' => '&AElig;',
        'c387' => '&Ccedil;',
        'c388' => '&Egrave;',
        'c389' => '&Eacute;',
        'c38a' => '&Ecirc;',
        'c38b' => '&Euml;',
        'c38c' => '&Igrave;',
        'c38d' => '&Iacute;',
        'c38e' => '&Icirc;',
        'c38f' => '&Iuml;',
        'c390' => '&ETH;',
        'c391' => '&Ntilde;',
        'c392' => '&Ograve;',
        'c393' => '&Oacute;',
        'c394' => '&Ocirc;',
        'c395' => '&Otilde;',
        'c396' => '&Ouml;',
        'c397' => '&times;',
        'c398' => '&Oslash;',
        'c399' => '&Ugrave;',
        'c39a' => '&Uacute;',
        'c39b' => '&Ucirc;',
        'c39c' => '&Uuml;',
        'c39d' => '&Yacute;',
        'c39e' => '&THORN;',
        'c39f' => '&szlig;',
        'c3a0' => '&agrave;',
        'c3a1' => '&aacute;',
        'c3a2' => '&acirc;',
        'c3a3' => '&atilde;',
        'c3a4' => '&auml;',
        'c3a5' => '&aring;',
        'c3a6' => '&aelig;',
        'c3a7' => '&ccedil;',
        'c3a8' => '&egrave;',
        'c3a9' => '&eacute;',
        'c3aa' => '&ecirc;',
        'c3ab' => '&euml;',
        'c3ac' => '&igrave;',
        'c3ad' => '&iacute;',
        'c3ae' => '&icirc;',
        'c3af' => '&iuml;',
        'c3b0' => '&eth;',
        'c3b1' => '&ntilde;',
        'c3b2' => '&ograve;',
        'c3b3' => '&oacute;',
        'c3b4' => '&ocirc;',
        'c3b5' => '&otilde;',
        'c3b6' => '&ouml;',
        'c3b7' => '&divide;',
        'c3b8' => '&oslash;',
        'c3b9' => '&ugrave;',
        'c3ba' => '&uacute;',
        'c3bb' => '&ucirc;',
        'c3bc' => '&uuml;',
        'c3bd' => '&yacute;',
        'c3be' => '&thorn;',
        'c3bf' => '&yuml;',
        'c592' => '&OElig;',
        'c593' => '&oelig;',
        'c5a0' => '&Scaron;',
        'c5a1' => '&scaron;',
        'c5b8' => '&Yuml;',
        'cb86' => '&circ;',
        'cb9c' => '&tilde;',
        'c692' => '&fnof;',
        'ce91' => '&Alpha;',
        'ce92' => '&Beta;',
        'ce93' => '&Gamma;',
        'ce94' => '&Delta;',
        'ce95' => '&Epsilon;',
        'ce96' => '&Zeta;',
        'ce97' => '&Eta;',
        'ce98' => '&Theta;',
        'ce99' => '&Iota;',
        'ce9a' => '&Kappa;',
        'ce9b' => '&Lambda;',
        'ce9c' => '&Mu;',
        'ce9d' => '&Nu;',
        'ce9e' => '&Xi;',
        'ce9f' => '&Omicron;',
        'cea0' => '&Pi;',
        'cea1' => '&Rho;',
        'cea3' => '&Sigma;',
        'cea4' => '&Tau;',
        'cea5' => '&Upsilon;',
        'cea6' => '&Phi;',
        'cea7' => '&Chi;',
        'cea8' => '&Psi;',
        'cea9' => '&Omega;',
        'ceb1' => '&alpha;',
        'ceb2' => '&beta;',
        'ceb3' => '&gamma;',
        'ceb4' => '&delta;',
        'ceb5' => '&epsilon;',
        'ceb6' => '&zeta;',
        'ceb7' => '&eta;',
        'ceb8' => '&theta;',
        'ceb9' => '&iota;',
        'ceba' => '&kappa;',
        'cebb' => '&lambda;',
        'cebc' => '&mu;',
        'cebd' => '&nu;',
        'cebe' => '&xi;',
        'cebf' => '&omicron;',
        'cf80' => '&pi;',
        'cf81' => '&rho;',
        'cf82' => '&sigmaf;',
        'cf83' => '&sigma;',
        'cf84' => '&tau;',
        'cf85' => '&upsilon;',
        'cf86' => '&phi;',
        'cf87' => '&chi;',
        'cf88' => '&psi;',
        'cf89' => '&omega;',
        'cf91' => '&thetasym;',
        'cf92' => '&upsih;',
        'cf96' => '&piv;',
        'e2809d' => '&rdquo;',
        'e2809c' => '&ldquo;',
        'e284a2' => '&trade;',
        'e28099' => '&rsquo;',
        'e28098' => '&lsquo;',
        'e280b0' => '&permil;',
        'e280a6' => '&hellip;',
        'e282ac' => '&euro;',
        'e28093' => '&ndash;',
        'e28094' => '&mdash;',
        'e280a0' => '&dagger;',
        'e280a1' => '&Dagger;',
        'e280b9' => '&lsaquo;',
        'e280ba' => '&rsaquo;',
        'e280b2' => '&prime;',
        'e280b3' => '&Prime;',
        'e280be' => '&oline;',
        'e28498' => '&weierp;',
        'e28491' => '&image;',
        'e2849c' => '&real;',
        'e284b5' => '&alefsym;',
        'e28690' => '&larr;',
        'e28691' => '&uarr;',
        'e28692' => '&rarr;',
        'e28693' => '&darr;',
        'e28694' => '&harr;',
        'e286b5' => '&crarr;',
        'e28790' => '&lArr;',
        'e28791' => '&uArr;',
        'e28792' => '&rArr;',
        'e28793' => '&dArr;',
        'e28794' => '&hArr;',
        'e28880' => '&forall;',
        'e28882' => '&part;',
        'e28883' => '&exist;',
        'e28885' => '&empty;',
        'e28887' => '&nabla;',
        'e28888' => '&isin;',
        'e28889' => '&notin;',
        'e2888b' => '&ni;',
        'e2888f' => '&prod;',
        'e28891' => '&sum;',
        'e28892' => '&minus;',
        'e28897' => '&lowast;',
        'e2889a' => '&radic;',
        'e2889d' => '&prop;',
        'e2889e' => '&infin;',
        'e288a0' => '&ang;',
        'e288a7' => '&and;',
        'e288a8' => '&or;',
        'e288a9' => '&cap;',
        'e288aa' => '&cup;',
        'e288ab' => '&int;',
        'e288b4' => '&there4;',
        'e288bc' => '&sim;',
        'e28985' => '&cong;',
        'e28988' => '&asymp;',
        'e289a0' => '&ne;',
        'e289a1' => '&equiv;',
        'e289a4' => '&le;',
        'e289a5' => '&ge;',
        'e28a82' => '&sub;',
        'e28a83' => '&sup;',
        'e28a84' => '&nsub;',
        'e28a86' => '&sube;',
        'e28a87' => '&supe;',
        'e28a95' => '&oplus;',
        'e28a97' => '&otimes;',
        'e28aa5' => '&perp;',
        'e28b85' => '&sdot;',
        'e28c88' => '&lceil;',
        'e28c89' => '&rceil;',
        'e28c8a' => '&lfloor;',
        'e28c8b' => '&rfloor;',
        'e29fa8' => '&lang;',
        'e29fa9' => '&rang;',
        'e2978a' => '&loz;',
        'e299a0' => '&spades;',
        'e299a3' => '&clubs;',
        'e299a5' => '&hearts;',
        'e299a6' => '&diams;',
    );

    // Decode UTF-8 code-table
    $HTML_SPECIAL_CHARS = array();
    foreach ($HTML_SPECIAL_CHARS_UTF8 as $hex => $html) {
        $key = '';
        if (strlen($hex) == 4) {
            $key = pack("CC", hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)));
        } elseif (strlen($hex) == 6) {
            $key = pack("CCC", hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2)));
        }

        if ($key) {
            $HTML_SPECIAL_CHARS[$key] = $html;
        }
    }

    // Common conversion
    $string = str_replace(array_keys($HTML_SPECIAL_CHARS), array_values($HTML_SPECIAL_CHARS), $string);

    /* note: apply htmlspecialchars if desired /before/ applying this function
    /* Only do the slow convert if there are 8-bit characters */
    /* avoid using 0xA0 (\240) in ereg ranges. RH73 does not like that */
    if (!preg_match("~[\200-\237]~", $string) and !preg_match("~[\241-\377]~", $string)) {
        return $string;
    }

    // reject too-short sequences
    $string = preg_replace("/[\302-\375]([\001-\177])/", "&#65533;\\1", $string);
    $string = preg_replace("/[\340-\375].([\001-\177])/", "&#65533;\\1", $string);
    $string = preg_replace("/[\360-\375]..([\001-\177])/", "&#65533;\\1", $string);
    $string = preg_replace("/[\370-\375]...([\001-\177])/", "&#65533;\\1", $string);
    $string = preg_replace("/[\374-\375]....([\001-\177])/", "&#65533;\\1", $string);
    $string = preg_replace("/[\300-\301]./", "&#65533;", $string);
    $string = preg_replace("/\364[\220-\277]../", "&#65533;", $string);
    $string = preg_replace("/[\365-\367].../", "&#65533;", $string);
    $string = preg_replace("/[\370-\373]..../", "&#65533;", $string);
    $string = preg_replace("/[\374-\375]...../", "&#65533;", $string);
    $string = preg_replace("/[\376-\377]/", "&#65533;", $string);
    $string = preg_replace("/[\302-\364]{2,}/", "&#65533;", $string);

    return $string;
}

// Since 2.0: Translate phrase to code
function hi18n($ft)
{
    $sph = '';

    $ex = separateString($ft, ' ');
    foreach ($ex as $w) {
        $sx = soundex($w);
        if ($sx[0] === '0') {
            continue;
        }

        $sph .= $sx;
    }

    // long phrases
    return substr($sph, 0, 32);
}

// Since 2.0: Check server request type
function request_type($type = 'POST')
{
    return $_SERVER['REQUEST_METHOD'] === $type ? true : false;
}

// Since 2.0; HTML show errors
function cn_snippet_messages($area = 'new')
{
    //exit();
    $delay = 7500;
    $result = '';

    for ($i = 0; $i < strlen($area); $i++) {
        $messages = cn_get_message($area[$i], 's');

        $type = 'notify';
        if ($area[$i] == 'e') {
            $type = 'error';
        } elseif ($area[$i] == 'w') {
            $type = 'warnings';
        }

        if ($messages) {
            $result .= '<div class="cn_' . $type . '_list">';
            foreach ($messages as $msg) {
                $NID = 'notify_' . ctime() . mt_rand();
                $result .= '<div class="cn_' . $type . '_item" id="' . $NID . '"><div><b>' . date('H:i:s', ctime()) . '</b> ' . $msg . '</div></div>';
                $result .= '<script>notify_auto_hide("' . $NID . '", ' . $delay . ');</script>';

                $delay += 1000;
            }
            $result .= '</div>';
        }
    }

    if ($result) {
        echo '<div class="cn_notify_overall">' . $result . '</div>';
    }
}

// Since 2.0: Get messages
function cn_get_message($area, $method = 's') // s-show, c-count
{
    $es = getMemcache('msg:stor');
    if (isset($es[$area])) {
        if ($method == 's') {
            return $es[$area];
        } elseif ($method == 'c') {
            return count($es[$area]);
        }
    }

    return null;
}

// Since 2.0: Show breadcrumbs
function cn_snippet_bc($sep = '&gt;')
{
    $bc = getMemcache('.breadcrumbs');
    echo '<div class="cn_breadcrumbs">';

    $ls = array();
    if (is_array($bc)) {
        foreach ($bc as $item) {
            $ls[] = '<span class="bcitem"><a href="' . $item['url'] . '">' . cnHtmlSpecialChars($item['name']) . '</a></span>';
        }
    }
    echo join(' <span class="bcsep">' . $sep . '</span> ', $ls);
    echo '</div>';
}

// Since 1.5.3
// GET Helper for single value
// $method[0] = * ---> htmlspecialchars ON
function REQ($var, $method = 'GETPOST')
{
    if ($method[0] == '*') {
        list($value) = (GET($var, substr($method, 1)));
        return cnHtmlSpecialChars($value);
    } else {
        list($value) = GET($var, $method);
        return $value;
    }
}

// Since 2.0: Cutenews HtmlSpecialChars
function cnHtmlSpecialChars($_str)
{
    $key = array('&' => '&amp;', '"' => '&quot;', "'" => '&#039;', '<' => '&lt;', '>' => '&gt;');
    $matches = null;
    preg_match('/(&amp;)+?/', $_str, $matches);
    if (count($matches) != 0) {
        array_shift($key);
    }
    return str_replace(array_keys($key), array_values($key), $_str);
}

// Since 2.0: Pack only required parameters
function cn_pack_url($GET, $URL = PHP_SELF)
{
    $url = $result = array();

    foreach ($GET as $k => $v) if ($v !== '') $result[$k] = $v;
    foreach ($result as $k => $v) $url[] = "$k=" . urlencode($v);

    list($ResURL) = hook('core/url_rewrite', array($URL . ($url ? '?' . join('&', $url) : ''), $URL, $GET));
    return $ResURL;
}

// Since 1.5.1: Simply read template file
function read_tpl($tpl = 'index')
{
    try {


        // get from cache
        $cached = getMemcache("tpl:$tpl");
        if ($cached) {
            return $cached;
        }

        // Get asset path
        if (preg_match('/\.(css|js)/i', $tpl)) {
            $fine = '';
        } else {
            $fine = '.tpl';
        }

        // Get plugin path
        if ($tpl[0] == '/') {
            $open = $this->cn_path_construct(SERVDIR, 'cdata', 'plugins') . substr($tpl, 1) . $fine;
        } else {
            $open = SKIN . DIRECTORY_SEPARATOR . ($tpl ? $tpl : 'default') . $fine;
        }

        // Try open
        $not_open = false;
        $r = fopen($open, 'r') or $not_open = true;
        if ($not_open) {
            return false;
        }

        ob_start();
        fpassthru($r);
        $ob = ob_get_clean();
        fclose($r);

        // caching file
        setMemcache("tpl:$tpl", $ob);

        return $ob;
    } catch (\Exception $e) {
        cn_throw_message($e->getMessage(), 'e');
    }
}

function echofooter()
{
    global $is_loged_in, $skin_footer, $lang_content_type, $skin_menu, $config_adminemail, $config_admin;

    if ($is_loged_in == TRUE)
        $skin_footer = str_replace("{menu}", $skin_menu, $skin_footer);
    else $skin_footer = str_replace("{menu}", " &nbsp; ", $skin_footer);

    //$skin_footer = get_skin($skin_footer);
    //$skin_footer = str_replace("{content-type}", $lang_content_type, $skin_footer);
    $skin_footer = str_replace("{exec-time}", round(microtime(true) - BQN_MU, 3), $skin_footer);
    $skin_footer = str_replace("{year-time}", date("Y"), $skin_footer);
    $skin_footer = str_replace("{email-name}", $config_adminemail, $skin_footer);
    $skin_footer = str_replace("{byname}", $config_admin, $skin_footer);

    die($skin_footer);
}

function cn_bc_menu($name, $url, $opt)
{
    $bc = getMemcache('.menu');
    $bc[$opt] = array('name' => $name, 'url' => $url);
    setMemcache('.menu', $bc);
}

// Since 1.5.2: Directory scan
function scan_dir($dir, $cond = '')
{
    $files = array();
    if ($dh = opendir($dir)) {
        while (false !== ($filename = readdir($dh))) {
            if (!in_array($filename, array('.', '..')) && ($cond == '' || $cond && preg_match("/$cond/i", $filename))) {
                $files[] = $filename;
            }
        }
    }
    return $files;
}


// Since 2.0: Test User ACL. Test for groups [user may consists requested group]
function testRoleAdmin($requested_acl, $requested_user = null, $is_self = false)
{
    // get user member session
    $user = getMember();

    // Deny ANY access of unauthorized member
    if (!$user) {
        return false;
    }

//        $acl = $user['acl'];
    $acl = $user['AdLevel'];
    $grp = getOption('#grp');

    $ra = separateString($requested_acl);

    // This group not exists, deny all
    if (!isset($grp[$acl])) {
        return false;
    }

    // Decode ACL, GRP string
    $gp = separateString($grp[$acl]['G']);
    $rc = separateString($grp[$acl]['A']);

    // ra la bien truyen vao
    // If requested acl not match with real allowed, break
    foreach ($ra as $Ar) {
        if (!in_array($Ar, $rc)) {
            return false;
        }
    }

    // Test group or self
    if ($requested_user) {
        // if self-check, check name requested user and current user
        if ($is_self && $requested_user['user_Account'] !== $user['user_Account']) {
            // xac ding user truyen vao <=> user hien tai
            return false;
        }

        // if group check, check: requested uses may be in current user group
        if (!$is_self) {
            if ($gp && !in_array($requested_user['acl'], $gp)) {
                //kiem tra user truyen vao user[acl]  <=> phan quyen trong nhom
                return false;
            } elseif (!$gp) {
                //ko ton tai phan quyen
                return false;
            }
        }
    }

    return true;
}

//// Since 2.0: Make 'Top menu'
//function cn_get_menu()
//{
//    $modules = hook('core/cn_get_menu', array
//    (
//        'editconfig' => array('Cd', 'Cấu hình chung'),
//        'cashshop' => array('Can', 'Cash Shop'),
//        'logout' => array('', 'Logout', 'logout'),
//    ));
//
//    if (getOption('main_site'))
//        $modules['my_site'] = getOption('main_site');
//
//    $result = '<ul>';
//    $mod = REQ('mod', 'GPG');
//
//    foreach ($modules as $mod_key => $var) {
//        if (!is_array($var)) {
//            $result .= '<li><a href="' . $this->cnHtmlSpecialChars($var) . '" target="_blank">' . 'Visit site' . '</a></li>';
//            continue;
//        }
//
//        $acl = isset($var[0]) ? $var[0] : false;
//        $name = isset($var[1]) ? $var[1] : '';
//        $title = isset($var[2]) ? $var[2] : '';
//        $app = isset($var[3]) ? $var[3] : '';
//
//        if ($acl && !testRoleAdmin($acl))
//            continue;
//
//        if (isset($title) && $title) $action = '&amp;action=' . $title; else $action = '';
//        if ($mod == $mod_key) $select = ' active '; else $select = '';
//
//        // Append urls for menu (preserve place)
//        if (isset($app) && $app) {
//            $actions = array();
//            $mv = separateString($app);
//
//            foreach ($mv as $vx)
//                if ($dt = REQ($vx))
//                    $actions[] = "$vx=" . urlencode($dt);
//
//            if ($actions) $action .= '&amp;' . join('&amp;', $actions);
//        }
//
//        $result .= '<li class = "' . $select . '"><a href="' . PHP_SELF . '?mod=' . $mod_key . $action . '">' . $name . '</a></li>';
//    }
//
//    $result .= "</ul>";
//    return $result;
//}

// Since 1.5.0: Force relocation
function cnRelocation($url)
{
    if (!$url) $url = $_SERVER['PHP_SELF'];
    header("Location: $url");
    echo '<html><head><title>Redirect...</title><meta http-equiv="refresh" content="0;url=' . $this->cnHtmlSpecialChars($url) . '"></head><body>Please wait... Redirecting to "' . $this->cnHtmlSpecialChars($url) . '...<br/><br/></body></html>';
    die();
}


// Since 2.0: Execute PHP-template
// 1st argument - template name, other - variables ==> mo file
function execTemplate()
{
    try {
        $args = func_get_args();
        $tpl = preg_replace('/[^a-z0-9_\/]/i', '', array_shift($args));

        $open = SKIN . '/' . ($tpl ? $tpl : 'default') . '.php';

        foreach ($args as $arg) {
            if (is_array($arg)) {
                foreach ($arg as $k0 => $v) {
                    $k = "__$k0";
                    $$k = $v;
                }
            } else {
                list($k, $v) = explode('=', $arg, 2);

                // <-- make local variable
                $k = "__$k";
                $$k = $v;
            }
        }

        if (file_exists($open)) {
            ob_start();
            include $open;
            $echo = ob_get_clean();
            return $echo;
        } else {
            throw new Exception("Not found file" . $open);
        }
    } catch (Exception $e) {
        throw new Exception($e->getMessage());
    }
}

// Since 1.5.0: Send Mail
function cn_send_mail($to, $subject, $message, $alt_headers = NULL)
{
    if (!isset($to)) return FALSE;
    if (!$to) return FALSE;

    $tos = separateString($to);
    $from = 'Cutenews <cutenews@' . $_SERVER['SERVER_NAME'] . '>';

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/plain;\r\n";
    $headers .= 'From: ' . $from . "\r\n";
    $headers .= 'Reply-to: ' . $from . "\r\n";
    $headers .= 'Return-Path: ' . $from . "\r\n";
    $headers .= 'Message-ID: <' . md5(uniqid(time())) . '@' . $_SERVER['SERVER_NAME'] . ">\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
    $headers .= "Date: " . date('r', time()) . "\r\n";

    if (!is_null($alt_headers)) $headers = $alt_headers;
    foreach ($tos as $v) if ($v) mail($v, $subject, $message, $headers);

    return true;
}

function cn_url_modify()
{
    global $PHP_SELF;
    $GET = $_GET;
    $args = func_get_args();
    $SN = $PHP_SELF;

    // add new params
    foreach ($args as $ks) {
        // 1) Control
        if (is_array($ks)) {
            foreach ($ks as $vs) {
                $id = $val = '';

                if (strpos($vs, '=') !== FALSE) {
                    list($id, $var) = explode('=', $vs, 2);
                } else {
                    $id = $vs;
                }
                if ($id == 'self') {
                    $SN = $var;
                } elseif ($id == 'reset') {
                    $GET = array();
                } elseif ($id == 'group') {
                    foreach ($vs as $a => $b) {
                        $GET[$a] = $b;
                    }
                }
            }
        } // 2) Subtract
        elseif (strpos($ks, '=') === FALSE) {
            $keys = explode(',', $ks);

            foreach ($keys as $key) {
                $key = trim($key);
                if (isset($GET[$key])) {
                    unset($GET[$key]);
                }
            }
        } // 3) Add
        else {
            list($k, $v) = explode('=', $ks, 2);

            $GET[$k] = $v;
            if ($v === '') {
                unset($GET[$k]);
            }
        }
    }

    return cn_pack_url($GET, $SN);
}

// Since 2.0: @bootstrap
function cn_load_skin()
{
    $config_skin = preg_replace('~[^a-z]~i', '', getOption('skin'));
    if (file_exists($skin_file = SERVDIR . "/skins/$config_skin.skin.php")) {
        include($skin_file);
    } else {
        die("Can't load skin $config_skin");
    }
}
