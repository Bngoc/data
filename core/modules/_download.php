<?php if (!defined('BQN_MU')) die('Access restricted');

add_hook('index/invoke_module', '*download_invoke');

function download_invoke()
{
    $arr_downlooad = [
        'media' => 'MediaFire',
        'onedrive' => 'OneDrive',
        '4share' => '4Share',
        'dropbox' => 'dropBox',
        'googledriver' => 'GoogleDriver',
    ];
    $mod = REQ('mod', 'GETPOST');
    cn_bc_add('Download', cn_url_modify(array('reset'), 'mod=' . $mod));

    $arr_downlooadShow = array();
    foreach ($arr_downlooad as $key => $item){
//        $file_meidea = getoption('download_'. $item);
        $arr_downlooadShow[$key]['href'] = getoption('download_'. $item);
        $arr_downlooadShow[$key]['name'] = $item;
    }

    cn_assign('arr_downlooadShow', $arr_downlooadShow);

    echoheader('-@my_download/style.css', "Nap The");
    echocomtent_here(exec_tpl('my_download/show_download'), cn_snippet_bc_re());
    echofooter();
}