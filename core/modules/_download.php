<?php if (!defined('BQN_MU')) die('Access restricted');

add_hook('index/invoke_module', '*download_invoke');

function download_invoke()
{
    $arr_downlooad = [
        'media' => 'MediaFire',
        'onedrive' => 'OneDrive',
        '4share' => '4Share'
    ];
    $mod = REQ('mod', 'GETPOST');
    cn_bc_add('Download', cn_url_modify(array('reset'), 'mod=' . $mod));

    $arr_downlooadShow = array();
    foreach ($arr_downlooad as $key => $item) {
        $arr_downlooadShow[$key]['href'] = getOption('download_' . $key);
        $arr_downlooadShow[$key]['name'] = $item;
    }

    $result_Data = [];
    foreach ($arr_downlooadShow as $key => $items) {
        if (isset($items['href']) && $items['href']) {
            $url = $items['href'];
            $filesize = getRemoteFilesize($url);
            $parts = parse_url($url);
            $name = basename($parts['path']);
//            $ext = pathinfo($url, PATHINFO_EXTENSION);
//            $name2 = pathinfo($url, PATHINFO_FILENAME);
            $result_Data[] = [
                'name' => $name,
                'filesize' => $filesize,
                'href' => $items['href'],
                'hostname' => $items['name']
            ];
        }
    }

    cn_assign('arr_downlooadShow', $result_Data);

    echo_header_web('-@my_download/style.css', "Nap The");
    echo_content_here(exec_tpl('my_download/show_download'), cn_snippet_bc_re());
    echo_footer_web();
}

function getRemoteFilesize($url, $formatSize = true, $useHead = true)
{
    if (false !== $useHead) {
        stream_context_set_default(array('http' => array('method' => 'HEAD')));
    }
    $head = array_change_key_case(get_headers($url, 1));
    $clen = isset($head['content-length']) ? $head['content-length'] : 0;

    if (!$clen) {
        return '---';
    }

    if (!$formatSize) {
        return $clen;
    }

    $size = $clen;
    switch ($clen) {
        case $clen < 1024:
            $size = $clen . ' B';
            break;
        case $clen < 1048576:
            $size = round($clen / 1024, 2) . ' KiB';
            break;
        case $clen < 1073741824:
            $size = round($clen / 1048576, 2) . ' MiB';
            break;
        case $clen < 1099511627776:
            $size = round($clen / 1073741824, 2) . ' GiB';
            break;
    }

    return $size;
}
