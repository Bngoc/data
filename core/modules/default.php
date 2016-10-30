<?php if (!defined('BQN_MU')) die('Access restricted');

add_hook('index/invoke_module', '*default_invoke');

// =====================================================================================================================

function default_invoke()
{
    echoheader('-@my_dashboard/style.css', "Error");
    echocomtent_here(exec_tpl('my_char/default'), cn_snippet_bc_re("Home", "Lỗi dữ liệu"));
//echo exec_tpl('my_dashboard/category');
    echofooter();

}