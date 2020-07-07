<?php

// Since 2.0: Get cached categories with acl test
function cn_get_categories($is_frontend = false)
{
    if ($cc = getMemcache('#categories'))
        $catgl = $cc;
    else {
        $catgl = getOption('#category');
        setMemcache('#categories', $catgl);
    }

    // Delete not allowed cats
    foreach ($catgl as $id => $v) {
        if ($id == '#') unset($catgl[$id]);
        elseif (!test_category($id) && !$is_frontend) unset($catgl[$id]);
    }

    return $catgl;
}

// Since 2.0: Test category accessible for current user
function test_category($cat)
{
    $user = getMember();
    $grp = getOption('#grp');

    if (!$user) {
        return false;
    }

    // Get from cache
    if ($cc = getMemcache('#categories'))
        $catgl = $cc;
    else {
        $catgl = getOption('#category');
        setMemcache('#categories', $catgl);
    }

    // View all category
    if (testRoleAdmin('Ccv')) {
        return true;
    }

    $acl = $user['acl'];
    $cat = separateString($cat);

    // Overall ACL test, with groups + own
    $acl = array_unique(array_merge(array($acl), separateString($grp[$acl]['G'])));

    foreach ($cat as $ct) {
        // Requested cat not exists, skip
        if (!isset($catgl[$ct])) {
            continue;
        }

        // Group list included (partially/fully) in group list for category
        $sp = separateString($catgl[$ct]['acl']);
        $is = array_intersect($sp, $acl);
        if (!$is) {
            return false;
        }
    }

    return true;
}

// Since 2.0: Get additional fields in groups
function cn_get_more_fields($defined = array())
{
    $more_fields = array();
    $mgrp = getOption('#more_list');

    foreach ($mgrp as $name => $item) {
        if (!($grp = $item['grp'])) $grp = '#basic';
        if (!isset($more_fields[$grp])) $more_fields[$grp] = array();

        if (isset($defined[$name]))
            $item['#value'] = $defined[$name];

        $more_fields[$grp][$name] = $item;
    }
    return array($more_fields, $mgrp);
}

// Since 1.5.2: Make HTML code for postponed date
function make_postponed_date($gstamp = 0)
{
    $_dateD = $_dateM = $_dateY = false;

    // Use current timestamp if no present
    if ($gstamp == 0) {
        $gstamp = ctime();
    }

    $day = date('j', $gstamp);
    $month = date('n', $gstamp);
    $year = date('Y', $gstamp);
    $ml = explode(',', getOption('mon_list'));

    for ($i = 1; $i < 32; $i++) {
        if ($day == $i) {
            $_dateD .= "<option selected value=$i>$i</option>";
        } else {
            $_dateD .= "<option value=$i>$i</option>";
        }
    }

    for ($i = 1; $i < 13; $i++) {
        $timestamp = mktime(0, 0, 0, $i, 1, 2003);
        $curr_mont = date('n', $timestamp) - 1;

        if ($ml && isset($ml[$curr_mont])) {
            $month_name = $ml[$curr_mont];
        } else {
            $month_name = date("M", $timestamp);
        }

        // ---
        if ($month == $i) {
            $_dateM .= "<option selected value=$i>" . $month_name . "</option>";
        } else {
            $_dateM .= "<option value=$i>" . $month_name . "</option>";
        }
    }

    for ($i = 2003; $i < (date('Y') + 8); $i++) {
        if ($year == $i) {
            $_dateY .= "<option selected value=$i>$i</option>";
        } else {
            $_dateY .= "<option value=$i>$i</option>";
        }
    }

    return array($_dateD, $_dateM, $_dateY, date('H', $gstamp), date('i', $gstamp), date('s', $gstamp));
}

function cn_snippet_ckeditor($ids = '')
{
    // pre-init
    $CKSmiles = $CKBar = array();
    for ($i = 1; $i <= 8; $i++) {
        $ck_bar = getOption("ck_ln{$i}");
        if ($ck_bar) $CKBar[] = '["' . join('","', explode(',', cnHtmlspecialchars($ck_bar))) . '"]';
    }

    $smiles = explode(',', getOption('smilies'));
    foreach ($smiles as $smile) $CKSmiles[] = "'$smile.gif'";

    $CKSmiles = join(', ', $CKSmiles);
    $CKBar = join(', ', $CKBar);
    $Cklang = getOption('cklang');
    if (empty($Cklang)) $Cklang = 'en';

    // show
    echo '<script src="' . getOption('http_script_dir') . '/core/ckeditor/ckeditor.js"></script>';
    echo '<script type="text/javascript">' . "\n";
    echo "(function() { var settings = {" . "\n";
    echo "skin: 'moono', width: 'auto', height: 350, customConfig: '', language: '$Cklang', entities_latin: false, entities_greek: false, \n";
    echo "toolbar: [ " . hook('settings/CKEDITOR_customize', $CKBar) . " ], \n";

    $add_opt = array();
    $compound = array();

    $add_opt['filebrowserBrowseUrl'] = PHP_SELF . '?mod=media&opt=inline';
    $add_opt['filebrowserImageBrowseUrl'] = PHP_SELF . '?mod=media&opt=inline';

    $add_opt = hook('settings/CKEDITOR_filemanager', $add_opt);
    foreach ($add_opt as $I => $V) $compound[] = "$I: \"$V\"";

    // Insert updated FileBrowser
    echo join(', ', $compound) . '};' . "\n";

    // Smilies
    echo 'CKEDITOR.config.smiley_path = "' . getOption('http_script_dir') . '/skins/emoticons/"; ' . "\n";
    echo 'CKEDITOR.config.smiley_images = [ ' . hook('settings/CKEDITOR_emoticons', $CKSmiles) . ' ];' . "\n";
    echo 'CKEDITOR.config.smiley_descriptions = [];' . "\n";
    echo "CKEDITOR.config.allowedContent = true;";

    $ids = separateString($ids);
    foreach ($ids as $id) {
        echo "CKEDITOR.replace( '" . trim($id) . "', " . hook('settings/CKEDITOR_SetsName', 'settings') . " );" . "\n";
    }

    echo hook('settings/CKEDITOR_Settings');

    echo '})(); </script>';
}

// Since 1.4.7: Insert smilies for adding into news/comments
function insert_smilies($insert_location, $break_location = false, $admincp = false)
{
    $i = 0;
    $output = false;
    $config_http_script_dir = getOption('http_script_dir');
    $smilies = separateString(getOption('smilies'));

    foreach ($smilies as $smile) {
        $i++;
        $smile = trim($smile);

        if ($admincp) {
            $output .= '<a href="#" onclick="insertAtCursor(document.getElementById(\'' . $insert_location . '\'), \' :' . $smile . ': \'); return false;"><img alt="' . $smile . '" src="/public/images/emoticons/' . $smile . '.gif" /></a>';
        } else {
            if (getOption('base64_encode_smile')) {
                $url = "data:image/png;base64," . base64_encode(join('', file(SERVDIR . '/skins/emoticons/' . $smile . '.gif')));
            } else {
                $url = getOption('http_script_dir') . "/public/images/emoticons/" . $smile . ".gif";
            }
            $output .= "<a href='#' onclick='insertext(\":$smile:\", \"$insert_location\"); return false;'><img style=\"border: none;\" alt=\"$smile\" src=\"$url\" /></a>";
        }

        if (isset($break_location) && intval($break_location) > 0 && $i % $break_location == 0) {
            $output .= "<br />";
        } else {
            $output .= "&nbsp;";
        }
    }

    return $output;
}

// Since 2.0: Unpack cookie for ACP
function cn_cookie_unpack($cookie)
{
    $list = array();

    $cookies = explode(',', $cookie);
    foreach ($cookies as $c) {
        $c = trim($c);
        if (isset($_COOKIE[$c])) {
            $list[] = unserialize(base64_decode($_COOKIE[$c]));
        } else {
            $list[] = array();
        }
    }

    return $list;
}

// Since 2.0: Pack cookie for ACP
function cn_cookie_pack()
{
    $args = func_get_args();
    $cookie = array_shift($args);

    $cookies = explode(',', $cookie);
    foreach ($cookies as $id => $cookie) {
        $cookie = trim($cookie);
        if ($args[$id]) {
            $data = base64_encode(serialize($args[$id]));
        } else {
            $data = null;
        }
        setcookie($cookie, $data);
    }
}

// Since 2.0: Basic function for list news
function cn_get_news($opts)
{
    $source = isset($opts['source']) ? $opts['source'] : '';
    $archive_id = isset($opts['archive_id']) ? intval($opts['archive_id']) : 0;

    $sort = isset($opts['sort']) ? $opts['sort'] : '';
    $dir = isset($opts['dir']) ? strtoupper($opts['dir']) : '';
    $st = isset($opts['start']) ? intval($opts['start']) : 0;
    $per_page = isset($opts['per_page']) ? intval($opts['per_page']) : 10;
    $cfilter = isset($opts['cfilter']) ? $opts['cfilter'] : array();
    $ufilter = isset($opts['ufilter']) ? $opts['ufilter'] : array();
    $nocat = isset($opts['nocat']) ? $opts['nocat'] : false;
    $page_alias = isset($opts['page_alias']) ? $opts['page_alias'] : '';
    $by_date = isset($opts['by_date']) ? $opts['by_date'] : '';
    $tag = isset($opts['tag']) ? trim(strtolower($opts['tag'])) : '';

    // sys
    $nlpros = isset($opts['nlpros']) ? intval($opts['nlpros']) : 0;

    // ---
    $qtree = array();
    $entries = array();
    $ls = array();
    $ppsort = FALSE;
    $nc = -1;
    $ed = $st + $per_page;
    $tc_time = ctime();
    $cpostponed = 0;
    $date_out = separateString($by_date, '-');

    // Quick search by page alias
    if ($page_alias) {
        if ($_id = bt_get_id($page_alias, 'pg_ts'))
            $ls = array($_id => $_id);
    } else {
        // Quick-Get tree structure
        $dirs = scan_dir(SERVDIR . '/data_db/news', '^[\d\-]+\.php$');
        foreach ($dirs as $tc) if (preg_match('/^([\d\-]+)\.php$/i', $tc, $c)) $qtree[$c[1]] = 0;

        // Empty sort is sort by date
        if ($sort == 'date') {
            $sort = '';
            if ($dir == 'A') $dir = 'R';
        }

        // Fetch from archives
        if ($archive_id) {
            $source_id = 'archive';
            $source = "archive-$archive_id";
        } else $source_id = $source;

        // -----
        // Optimize 'date' function, select by date range
        $range_fy = $range_ty = $range_fm = $range_tm = $range_fd = $range_td = 0;
        $do = count($date_out);

        // Range for Year
        if ($date_out[0]) {
            $range_fy = strtotime($date_out[0] . '-01-01 00:00:00');
            $range_ty = strtotime($date_out[0] . '-12-31 23:59:59');
        }

        // Range for Month
        if ($date_out[0] && $date_out[1]) {
            $dy = $ty = $date_out[0];
            $dm = $tm = $date_out[1];

            // Don't overhead month
            if ($date_out[1] == 12) {
                $ty++;
                $tm = 1;
            } else $tm++;

            $range_fm = strtotime($dy . '-' . $dm . '-01 00:00:00');
            $range_tm = strtotime($ty . '-' . $tm . '-01 00:00:00');
        }

        // Range for Day
        if ($date_out[0] && $date_out[1] && $date_out[2]) {
            $range_fd = strtotime($date_out[0] . '-' . $date_out[1] . '-' . $date_out[2] . ' 00:00:00');
            $range_td = strtotime($date_out[0] . '-' . $date_out[1] . '-' . $date_out[2] . ' 23:59:59');
        }

        // Fetch all indexes?
        if ($sort) $ppsort = TRUE;
        if ($dir == 'R') $ppsort = TRUE;

        // Archives list
        $archive_list = db_get_archives();

        // Get news listing [and for archive]
        if (in_array($source_id, array('', 'draft', 'archive', 'A2'))) {
            do {
                $wo = db_index_bind($source);
                while (NULL !== ($it = db_index_next($wo))) {
                    $id = $it['id'];
                    $uid = $it['uid'];
                    $user = array();

                    // Get user name, if needed
                    if ($sort == 'author' || $ufilter)
                        $user = db_user_by($uid);

                    // Count prospected news
                    if ($id > $tc_time) $cpostponed++;

                    // skip postponed or active
                    if (!$nlpros && $id > $tc_time) continue;

                    // Not load other dates [for exact date]
                    if ($do) {
                        if ($date_out[0] && ($id < $range_fy || $id > $range_ty)) continue;
                        if ($date_out[1] && ($id < $range_fm || $id > $range_tm)) continue;
                        if ($date_out[2] && ($id < $range_fd || $id > $range_td)) continue;
                    }

                    // if nocat, show news without category
                    if ($nocat && $it['c'] && empty($cfilter))
                        continue;

                    // category test
                    if ($cfilter && !hlp_check_cat($it['c'], $cfilter))
                        continue;

                    // user test
                    if ($ufilter && !in_array($user['name'], $ufilter))
                        continue;

                    // by tag (reduces productivity)
                    if ($tag) {
                        $dt = hlp_req_cached_nloc($id);
                        if (!hlp_check_tag($dt[$id]['tg'], $tag)) continue;
                    }

                    // Turn on $ppsort (may reduces productivity)
                    if (!$ppsort) {
                        $nc++;
                        if ($nc < $st) continue;
                        if ($per_page && $nc >= $ed)
                            break 2;
                    }

                    // Sort by...
                    if ($sort == 'comments') $ls[$id] = $it['co'];
                    elseif ($sort == 'author') $ls[$id] = $user['name'];
                    else $ls[$id] = $id;
                }

                // Release bind
                db_index_unbind($wo);

                // Require more from next archive
                if ($source_id == 'A2' && count($archive_list)) {
                    $aitem = array_shift($archive_list);
                    $source = 'archive-' . $aitem['id'];
                } else break;
            } while (TRUE);
        }

        // ---
        // R-reverse direction
        if ($dir == 'R') $ls = array_reverse($ls, TRUE);

        // Sorting, if selected
        if ($ppsort) {
            if ($dir == 'A') asort($ls);
            elseif ($dir == 'D') arsort($ls);

            if ($per_page) $ls = array_slice($ls, $st, $per_page, TRUE);
            elseif ($st) $ls = array_slice($ls, $st, NULL, TRUE);
        }
    }

    // --
    // Load entries

    cn_cache_block_clear('nloc-');
    foreach ($ls as $id => $_t) {
        $block = hlp_req_cached_nloc($id);
        $entries[$id] = $block[$id];
    }

    // meta-info
    $rev['qtree'] = $qtree;
    $rev['cpostponed'] = $cpostponed;

    return array($entries, $rev);
}

// Since 2.0: Get next item from index
function db_index_next($bind)
{
    $e = trim(fgets($bind['rs']));
    if (!$e) return NULL;

    list($id, $c, $ui, $co) = explode(':', $e);

    $id = base_convert($id, 36, 10);
    $ui = base_convert($ui, 36, 10);

    return array('id' => $id, 'c' => $c, 'uid' => $ui, 'co' => $co);
}

// Since 2.0: Close bind file
function db_index_unbind($bind)
{
    if (is_resource($bind['rs']))
        fclose($bind['rs']);
}


// Since 2.0: Clear cache blocks
function cn_cache_block_clear($id)
{
    global $_CN_cache_block_id;

    foreach ($_CN_cache_block_id as $ccid => $_t) {
        if (substr($ccid, 0, strlen($id)) === $id)
            unset($_CN_cache_block_id[$ccid]);
    }
}

// Make category by category id(s)
function news_make_category($category)
{
    // User has selected multiple categories
    if (is_array($category)) {
        $nc = array();
        foreach ($category as $cvalue) {
            if (!test_category($cvalue)) {
                msg_info('Not allowed category');
            }

            $nc[] = intval($cvalue);
        }

        return implode(',', $nc);
    } else {
        // Single or nothing cat
        if (test_category($category)) {
            msg_info(__('Not allowed category'));
        }

        return $category;
    }
}

// Since 2.0: Get BTree by unique id hash
function bt_get_id($id, $area = 'std')
{
    $m5 = md5($id);
    $vd = cn_touch_get(ROOT . '/admin/data_db/btree/' . substr($m5, 0, 2) . '.php');
    return isset($vd[$area][$m5]) ? $vd[$area][$m5] : NULL;
}

// Since 2.0: Set by BTree uniquie data
function bt_set_id($id, $data, $area = 'std')
{
    $m5 = md5($id);
    $sn = ROOT . '/admin/data_db/btree/' . substr($m5, 0, 2) . '.php';
    $vd = cn_touch_get($sn);

    if (!isset($vd[$area])) $vd[$area] = array();
    $vd[$area][$m5] = $data;

    cn_fsave($sn, $vd);
}

// Since 2.0: Delete B-Tree index
function bt_del_id($id, $area)
{
    $m5 = md5($id);
    $sn = ROOT . '/admin/data_db/btree/' . substr($m5, 0, 2) . '.php';
    $vd = cn_touch_get($sn);

    if (isset($vd[$area][$m5]))
        unset($vd[$area][$m5]);

    cn_fsave($sn, $vd);
}

// Since 2.0: Save serialized array
function cn_fsave($dest, $data = array())
{
    $fn = $dest;
    $bk = $fn . '-' . mt_rand() . '.bak';

    $w = fopen($bk, 'w+') or die("Can't save data at [$bk]");
    fwrite($w, "<?php die('Direct call - access denied'); ?>\n");
    fwrite($w, serialize($data));
    fclose($w);

    return rename($bk, $fn);
}

// Since 2.0: Add more fields to entry
function cn_more_fields_apply($e, $dt)
{
    $deny = FALSE;
    $applied = array();

    if (!$dt) $dt = array();

    $mgrp = getOption('#more_list');
    foreach ($dt as $id => $data) {
        if (!isset($mgrp[$id])) {
            $deny = __('Field ID not exists', $id);
            break;
        } elseif ($mgrp[$id]['req'] && $data === '') {
            $deny = __('Fill required field [' . $id . ']');
            break;
        } else {
            $applied[$id] = $data;
        }
    }

    $e['mf'] = $applied;
    return array($e, $deny);
}

// Since 2.0: Replace all {name} and [name..] .. [/name] in template file
function entry_make($entry, $template_name, $template_glob = 'default', $section = '')
{
    global $_raw_md5;

    $_raw_md5 = array();
    $template = cn_get_template($template_name, strtolower($template_glob));

    // Get raw data
    list($template, $raw_vars) = cn_extrn_raw_template($template);

    // Extrn function for replace
    $template = cn_extrn_morefields($template, $entry, $section);

    // Hooks before
    list($template) = hook('core/entry_make_start', array($template, $entry, $template_name, $template_glob));

    // Catch { ... }
    if (preg_match_all('/\{(.*?)\}/is', $template, $tpls, PREG_SET_ORDER)) {
        foreach ($tpls as $tpl) {
            $result = '';
            list($tplc, $tpla) = explode('|', $tpl[1], 2);

            // send modifiers
            $short = "cn_modify_" . ($section ? $section . '_' : "");
            $short .= preg_replace('/[^a-z]/i', '_', $tplc);
            if (function_exists($short)) $result = call_user_func($short, $entry, explode('|', $tpla));
            $template = str_replace($tpl[0], $result, $template);
        }
    }

    // Extern function [middle]
    $template = cn_extrn_if_cond($template);

    // Hooks middle
    list($template) = hook('core/entry_make_mid', array($template, $entry, $template_name, $template_glob));

    // Catch[bb-tag]...[/bb-tag]
    if (preg_match_all('/\[([\w-]+)(.*?)\](.*?)\[\/\\1\]/is', $template, $tpls, PREG_SET_ORDER)) {
        foreach ($tpls as $tpl) {
            $result = '';
            $short = "cn_modify_bb_" . ($section ? $section . '_' : "");
            $short .= preg_replace('/[^a-z]/i', '_', $tpl[1]);
            if (function_exists($short)) $result = call_user_func($short, $entry, $tpl[3], $tpl[2]); // entry, text, options
            $template = str_replace($tpl[0], $result, $template);
        }
    }

    // Hooked
    list($template) = hook('core/entry_make_end', array($template, $entry, $template_name, $template_glob));

    // UTF-8 -- convert to entities on frontend
    if ($section == 'comm' && getOption('comment_utf8html')) {
        $template = ($template);
    } elseif (!$section && getOption('utf8html')) {
        $template = ($template);
    }

    // Return raw data
    list($template) = cn_extrn_raw_template($template, $raw_vars);

    return $template;
}


//---------------------------Start coreflat.php--------------------------------


// Since 2.0: Update external (e.g. tags)
function db_update_aux_admin($entry, $type = 'add', $storent = array())
{
    // --- do update tags
    $tags = cn_touch_get('/cdata/news/tagcloud.php');

    $tg = spsep($entry['tg']);
    foreach ($tg as $i => $v) $tg[$i] = trim($v);

    // Update tags require diffs
    if ($type == 'update')
    {
        $st = spsep($storent['tg']);
        foreach ($st as $i => $v) $st[$i] = trim($v);

        $tdel = array_diff($st, $tg);
        $tadd = array_diff($tg, $st);

        // add & delete
        foreach ($tadd as $tag) $tags[$tag]++;
        foreach ($tdel as $tag)
        {
            $tags[$tag]--;
            if ($tags[$tag] <= 0) unset($tags[$tag]);
        }
    }
    else
    {
        foreach ($tg as $tag)
        {
            // Add news
            if ($type == 'add')
            {
                $tags[$tag]++;
            }
            // Delete news
            elseif ($type == 'delete')
            {
                $tags[$tag]--;
                if ($tags[$tag] <= 0) unset($tags[$tag]);
            }
        }
    }

    cn_fsave('/cdata/news/tagcloud.php', $tags);
}

// Since 2.0: Update overall data about index
function db_index_update_overall_admin($source = '')
{
    $ct = ctime();
    $period = 30*24*3600;

    $fn = db_index_file_detect($source);
    $ls = file($fn);

    $i = array
    (
        'uids' => array(),
        'locs' => array(),
        'coms' => 0,
        'min_id' => $ct,
    );

    foreach ($ls as $vi)
    {
        list($id,,$ui,$co) = explode(':', $vi);

        $id  = base_convert($id, 36, 10);
        $loc = db_get_nloc($id);

        $i['uids'][$ui]++;
        $i['coms'] += $co;
        $i['locs'][$loc]++;

        if ($i['min_id'] > $id)
            $i['min_id'] = $id;
    }

    // Active news is many, auto archive it (and user is hasn't draft rights)
    if ($source == '' && $i['min_id'] < $ct - $period && getOption('auto_archive') && !test('Bd'))
    {
        $cc = db_make_archive(0, ctime());
        cn_throw_message('Autoarchive performed');

        if (getOption('notify_status') && getOption('notify_archive'))
            cn_send_mail(getOption('notify_email'), i18n("Auto archive news"), i18n("Active news has been archived (%1 articles)", $cc));

        // Refresh overall index
        return db_index_update_overall();
    }

    // save meta-data
    $meta = db_index_file_detect("meta-$source");
    $w = fopen($meta, "w+"); fwrite($w, serialize($i)); fclose($w);

    return TRUE;
}

// Since 2.0: if no user diffs, delete user
function db_user_update_admin()
{
    $cp = array();
    $args = func_get_args();
    $username = array_shift($args);

    if (!$username)
        return NULL;

    // -------
    $fn = '/cdata/users/' . substr(md5($username), 0, 2) . '.php';
    $cu = cn_touch_get($fn, TRUE);

    foreach ($args as $v) {
        list($a, $b) = explode('=', $v, 2);
        $cp[$a] = $b;
    }

    // Create main block
    if (!isset($cu['name'])) $cu['name'] = array();
    if (!isset($cu['name'][$username])) $cu['name'][$username] = array();

    // Update fields
    foreach ($cp as $i => $v) $cu['name'][$username][$i] = $v;

    // Save DB
    cn_fsave($fn, $cu);

    // -------
    // Make references
    if (isset($cp['id'])) // ID -> USERNAME
    {
        $cu = cn_touch_get($lc = '/cdata/users/' . substr(md5($cp['id']), 0, 2) . '.php', TRUE);

        if (!isset($cu['id'])) $cu['id'] = array();
        $cu['id'][$cp['id']] = $username;
        cn_fsave($lc, $cu);
    }

    if (isset($cp['email'])) // EMAIL -> USERNAME
    {
        $cu = cn_touch_get($lc = '/cdata/users/' . substr(md5($cp['email']), 0, 2) . '.php', TRUE);

        if (!isset($cu['email'])) $cu['email'] = array();
        $cu['email'][$cp['email']] = $username;
        cn_fsave($lc, $cu);
    }

    return TRUE;
}

// Since 2.0: Make backup file
function db_make_bk($fn)
{
    return $fn . '-' . mt_rand() . '.bak';
}

// Since 2.0: Append to index new entry
function db_index_add($id, $category, $uid, $source = '')
{
    $fn = db_index_file_detect($source);
    $dest = db_make_bk($fn);

    $i = TRUE;
    $s = base_convert($id, 10, 36) . ':' . $category . ":" . base_convert($uid, 10, 36) . ':0::' . "\n";

    $r = fopen($fn, 'r');
    $w = fopen($dest, 'w+');

    while ($a = fgets($r)) {
        list($i36) = explode(':', $a);

        if (base_convert($i36, 36, 10) < $id && $i) {
            $i = FALSE;
            fwrite($w, $s);
        }

        fwrite($w, $a);
    }

    // Not inserted before, insert after
    if ($i) fwrite($w, $s);

    fclose($r);
    fclose($w);

    return rename($dest, $fn);
}

// Since 2.0: Load block database entries
// @permanent alias of cn_touch_get for Flat DB structure
function db_news_load($location)
{
    if (substr($location, 0, 4) == '1970')
        return array();

    return cn_touch_get(ROOT . '/admin/data_db/news/' . $location . '.php');
}

// Since 2.0: Load metadata from index
// @Return: array $uids, array $locs, int $coms
function db_index_meta_load($source = '', $load_users = FALSE)
{
    $fn = db_index_file_detect("meta-$source");
    $ls = unserialize(join('', file($fn)));

    // Decode userids
    $uids = array();

    if ($load_users) {
        foreach ($ls['uids'] as $id => $ct) {
            $id = base_convert($id, 36, 10);
            $user = db_user_by($id);

            if ($user['name'])
                $uids[$user['name']] = $ct;
        }

        $ls['uids'] = $uids;
    }

    return $ls;
}

// Since 2.0: Get all archives
function db_get_archives()
{
    $archs = array();
    $fn = db_index_file_detect('archive');
    $ti = file($fn);

    foreach ($ti as $vi) {
        list($archid, $min_id, $max_id, $count) = explode('|', $vi);
        $archs[$archid] = array('id' => $archid, 'c' => $count, 'min' => $min_id, 'max' => $max_id);
    }

    // By last added date
    krsort($archs);
    return $archs;
}

// Since 2.0: Helper for db_index_(load|save)
function db_index_file_detect($source = '')
{
    $fn = SERVDIR . '/data_db/news';

    // Aliases for active news
    if ($source == 'iactive' || $source == 'postpone' || $source == 'A2')
        $source = '';

    if ($source == '') $fn .= '/iactive.txt';
    elseif ($source == 'draft') $fn .= '/idraft.txt';
    elseif (substr($source, 0, 7) == 'archive') $fn .= '/' . $source . '.txt';
    elseif (substr($source, 0, 4) == 'meta') {
        $source = substr($source, 5);
        if (!$source) $source = 'iactive';
        $fn .= '/meta-' . $source . '.txt';
    }

    if (!file_exists($fn)) fclose(fopen($fn, "w+"));

    return $fn;
}

// Since 2.0: Get bind for index file
function db_index_bind($source = '')
{
    $fn = db_index_file_detect($source);
    $fm = db_index_file_detect("meta-$source");

    $bind = array(
        'sc' => $source,
        'fn' => $fn,
        'mt' => $fm,
        'rs' => fopen($fn, 'r'),
    );

    return $bind;
}

// ------------------------------------------------------------------------------------------------------------ NEWS ---

// Since 2.0: Tranform $ID to date
function db_get_nloc($id)
{
    return date('Y-m-d', $id);
}

// Since 2.0: Save block database entries
// @permanent alias of cn_fsave for Flat DB structure
function db_save_news($es, $location)
{
    if (substr($location, 0, 4) == '1970') {
        return false;
    }

    return cn_fsave(ROOT . '/admin/data_db/news/' . $location . '.php', $es);
}

//---------------------------END: coreflat.php--------------------------------

// // Check TODO
//function cn_get_news_1($opts)
//{
//    $FlatDB = new FlatDB();
//
//    // Source must be:
//    // -----------------
//    // null -- active news only
//    // 'draft'
//    // 'archive'
//    // 'A2' -- active news and archives
//    // -----------------
//
//    $source = isset($opts['source']) ? $opts['source'] : '';
//    $archive_id = isset($opts['archive_id']) ? intval($opts['archive_id']) : 0;
//
//    // Sorting
//    $sort = isset($opts['sort']) ? $opts['sort'] : '';
//    $dir = isset($opts['dir']) ? strtoupper($opts['dir']) : '';
//
//    // Pagination
//    $st = isset($opts['start']) ? intval($opts['start']) : 0;
//    $per_page = isset($opts['per_page']) ? intval($opts['per_page']) : 10;
//
//    // Filters
//    $page_alias = isset($opts['page_alias']) ? $opts['page_alias'] : '';
//    $cfilter = isset($opts['cfilter']) ? $opts['cfilter'] : array();
//    $ufilter = isset($opts['ufilter']) ? $opts['ufilter'] : array();
//    $tag = isset($opts['tag']) ? trim(strtolower($opts['tag'])) : '';
//    $only_active = isset($opts['only_active']) ? $opts['only_active'] : false;
//
//    // System
//    $nocat = isset($opts['nocat']) ? $opts['nocat'] : false;
//    $by_date = isset($opts['by_date']) ? $opts['by_date'] : '';
//    $nlpros = isset($opts['nlpros']) ? intval($opts['nlpros']) : 0;
//
//    /* ============================================================================================================== */
//
//    // Prepare vars
//    // ------------------
//
//    if ($only_active) {
//        $source = '';
//    }
//
//    $overall = 0;
//    $ufilter = $FlatDB->load_users_id($ufilter);
//    $date_out = separateString($by_date, '-');
//
//    // Match news by page-alias
//    // -------------------
//    if ($page_alias) {
//        if ($_id = bt_get_id($page_alias, 'pg_ts')) {
//            $FlatDB->list = array($_id => array());
//        }
//    }
//    // Preloading indexes
//    // ------------------
//    else {
//        if ($source === '') {
//            $FlatDB->load_by();
//        } elseif ($source === 'archive') {
//            $FlatDB->load_by("archive-$archive_id.txt");
//        } elseif ($source === 'draft') {
//            $FlatDB->load_by('idraft.txt');
//        } elseif ($source === 'A2') {
//            $FlatDB->load_overall();
//        } else {
//            die("CN Internal error: source not recognized\n");
//        }
//
//        // Expand required data
//        $FlatDB->load_ext_by(array
//        (
//            'tg' => $tag, // title or sort by tags
//            'title' => (strtolower($sort) === 'title'), // sort by title
//            'author' => ($sort === 'author'), // sort by author name
//        ));
//
//        // Filtering data
//        // ----------------
//
//        // $cfilter, $ufilter - intersect (one match) filter by category and user_id
//        // $nocat   = if has, and $cfilter is empty, stay news withot category only
//        // $date_out = '[Y]-[m]-[d]' if present, stay only this date (-,Y,Y-m,Y-m-d)
//        // $nlpros  = if present, show prospected (postponed) news
//
//        $FlatDB->filters($cfilter, $ufilter, $tag, $nocat, $date_out, $nlpros);
//        $FlatDB->sorting($sort, $dir);
//
//        // Pagination
//        // ----------
//        $overall = count($FlatDB->list);
//        $FlatDB->slicing($st, $per_page);
//    }
//
//    // Get news entries
//    $entries = $FlatDB->load_entries();
//
//    // Get news structure
//    // -------------------------
//
//    $qtree = array();
//    $dirs = scan_dir(cn_path_construct(SERVDIR, 'data_db', 'news'), '^[\d\-]+\.php$');
//    foreach ($dirs as $tc) {
//        if (preg_match('/^([\d\-]+)\.php$/i', $tc, $c)) {
//            $qtree[$c[1]] = 0;
//        }
//    }
//
//    // meta-info
//    $rev = array(
//        'qtree' => $qtree,
//        'overall' => $overall,
//        'cpostponed' => $FlatDB->_item_postponed
//    );
//
//    return array($entries, $rev);
//}
