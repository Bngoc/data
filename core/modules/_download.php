<?php if (!defined('BQN_MU')) die('Access restricted');

add_hook('index/invoke_module', '*download_invoke');
//=====================================================================================================================
function download_invoke()
{
    $arr_downlooad = [
        'media' => '',
        'onedrive' => '',
        '4share' => '',
        'dropbox' => '',
        'googledriver' => '',
    ];
    $arr_downlooadShow = array();
    foreach ($arr_downlooad as $key => $item){
//        $file_meidea = getoption('download_'. $item);
        $arr_downlooadShow[$item]['href'] = getoption('download_'. $item);
    }

    cn_assign('arr_downlooadShow', $arr_downlooadShow);

    echoheader('-@my_download/style.css', "Nap The");
    echocomtent_here(exec_tpl('my_download/show_download'), cn_snippet_bc_re());
    echofooter();
}