<?php if (!defined('BQN_MU')) die('Access restricted');

add_hook('index/invoke_module', '*default_invoke');

// =====================================================================================================================

function default_invoke()
{
    echoheader('-@defaults/style.css', "Error");
    echocomtent_here(exec_tpl('defaults/default'), cn_snippet_bc_re("Home", "Lỗi dữ liệu"));
    echofooter();

}