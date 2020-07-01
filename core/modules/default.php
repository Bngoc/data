<?php if (!defined('BQN_MU')) {
    die('Access restricted');
}

add_hook('index/invoke_module', '*default_invoke');

// =====================================================================================================================

function default_invoke()
{
    echo_header_web('-@defaults/style.css', "Error");
    echo_content_here(exec_tpl('defaults/default'), cn_snippet_bc_re("Home", "Lỗi dữ liệu"));
    echo_footer_web();
}
