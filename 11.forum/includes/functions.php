<?php if (!defined('BQN_MU')) { die('Access restricted'); }

function pf_script_with_get($script) {
	$page = $script;
	$page = $page . "?";
	
	foreach($_GET as $key => $val) {
		$page = $page . $key . "=" . $val . "&";  
	}
	
	return substr($page, 0, strlen($page)-1);
}

function cn_path_uri()
{
    $s = &$_SERVER;
    $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true:false;
    $sp = strtolower($s['SERVER_PROTOCOL']);
    $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
    $port = $s['SERVER_PORT'];
    $port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
    $host = isset($s['HTTP_X_FORWARDED_HOST']) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
    $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
    $uri = $protocol . '://' . $host . dirname($_SERVER['SCRIPT_NAME']);
    //$uri = $protocol . '://' . $host . $s['REQUEST_URI'];
    //$segments = explode('?', $uri, 2);
    //$url = $segments[0];
    //return $url;
    return $uri;
}
?>