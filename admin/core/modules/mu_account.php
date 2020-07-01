<?php if (!defined('BQN_MU')) {
    die('Access restricted');
}

add_hook('index/invoke_module', '*account_invoke');

// =====================================================================================================================

function account_invoke()
{
}
