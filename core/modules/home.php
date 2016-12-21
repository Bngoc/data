<?php if (!defined('BQN_MU')) die('Access restricted');

add_hook('index/invoke_module', '*home_invoke');

// =====================================================================================================================

function home_invoke()
{
    $per_page = 2;
//    list($page, $opt, $sub) = GET('page, opt, sub');
//    $mod = REQ('mod', 'GETPOST');
//    $opt = REQ('opt', 'GETPOST');

    $page = intval(REQ('page', 'GETPOST'));
    if (empty($page)) $pageLimit = 0;

    if ($page != 0) $pageLimit = ($page -1)*$per_page;

    $result_Count_F = do_select_ortherForum("SELECT COUNT(*) as numCount FROM thread WHERE open = 1 AND postuserid IN (SELECT userid from user where usergroupid in (5,6,7,9))");
    $countNotifyForum = $result_Count_F[0]['numCount'];

    if ($countNotifyForum > 50) $countNotifyForum = 50;
    if($countNotifyForum) {
        $myQuery_F = 'SELECT thread.threadid, thread.title, thread.postuserid, thread.postusername, thread.lastpost, thread.keywords, usergroup.title as titleUser  FROM thread, user, usergroup WHERE open = 1 AND postuserid in (select userid from user where usergroupid in (5,6,7,9)) AND thread.postuserid = user.userid AND user.usergroupid = usergroup.usergroupid order by lastpost desc limit ' . $pageLimit . ',' . $per_page .';';
        $dataNotifyForum = do_select_ortherForum($myQuery_F);

        foreach ($dataNotifyForum as $key => $item) {
            $dataNotifyForum[$key]['urlForum'] = ewConvertFromUtf8($item['title']);
            $keywords = str_replace(',', '', $item['title']);
            if (strlen($keywords) > 45) {
                $keywords = substr($keywords, 0, 45) . '...';
            }
            $dataNotifyForum[$key]['title'] = $keywords;
        }

//    list($item_read, $get_paging) = cn_arr_pagina($dataNotifyForum, cn_url_modify(array('reset')), $page, $per_page);

        $item_read = $dataNotifyForum;
        $get_paging = cn_countArr_pagination($countNotifyForum, cn_url_modify(array('reset')), $page, $per_page);
    }

//    $dashboard = array
//    (
//        'editconfig:sysconf:Csc' => 'System configurations',
//        'editconfig:personal:Cp' => 'Personal options',
//        'editconfig:templates:Ct' => 'Templates',
//        'editconfig:category:Cc' => 'Categories',
//        'editconfig:intwiz:Ciw' => 'Integration wizard',
//        'media:media:Cmm' => 'Media manager',
//        'editconfig:userman:Cum' => 'Users manager',
//        'editconfig:group:Cg' => 'Groups',
//        'editconfig:backup:Cb' => 'Backups',
//        'editconfig:comments:Com' => 'Comments',
//        'editconfig:archives:Ca' => 'Archives',
//        'editconfig:ipban:Cbi' => 'Block IP',
//        'editconfig:morefields:Caf' => 'Additional fields',
//        'editconfig:wreplace:Crw' => 'Replace words',
//        'editconfig:logs:Csl' => 'System logs',
//        'editconfig:widgets:Cwp' => 'Plugins',
//        'maint:maint:Cmt' => 'Maintenance',
//        'editconfig:locale:Clc' => 'Localization',
//        'editconfig:script:Csr' => 'HTML scripts', // Csr
//        'editconfig:selfchk:Cpc' => 'Permission check',
//    );
//
//    // Call dashboard extend
//    $dashboard = hook('extend_dashboard', $dashboard);
//
//    // Exec
//    $mod = REQ('mod', 'GETPOST');
//    $opt = REQ('opt', 'GETPOST');
//
//
//
//
//    $images = array
//    (
//        'personal' => 'user.gif',
//        'userman' => 'users.gif',
//        'sysconf' => 'options.gif',
//        'category' => 'category.png',
//        'templates' => 'template.png',
//        'backup' => 'archives.gif',
//        'archives' => 'arch.png',
//        'media' => 'images.gif',
//        'intwiz' => 'wizard.gif',
//        'logs' => 'list.png',
//        'selfchk' => 'check.png',
//        'ipban' => 'block.png',
//        'widgets' => 'widgets.png',
//        'wreplace' => 'replace.png',
//        'morefields' => 'more.png',
//        'maint' => 'settings.png',
//        'group' => 'group.png',
//        'locale' => 'locale.png',
//        'script' => 'script.png',
//        'comments' => 'comments.png',
//    );
//
//    // More dashboard images
//    $images = hook('extend_dashboard_images', $images);
//
//    foreach ($dashboard as $id => $name) {
//        list($mod, $opt, $acl) = explode(':', $id, 3);
//
//        //if (!test($acl))
//        {
//            // unset($dashboard[$id]);
//            //continue;
//        }
//
//        $item = array
//        (
//            //'name' => i18n($name),
//            'name' => $name,
//            'img' => isset($images[$opt]) ? $images[$opt] : 'home.gif',
//            'mod' => $mod,
//            'opt' => $opt,
//        );
//
//        $dashboard[$id] = $item;
//    }
//

    //$member = member_get();

    //$meta_draft = db_index_meta_load('draft');
    //$drafts =isset($meta_draft['locs'])? intval(array_sum($meta_draft['locs'])):false;

    //if ($drafts && test('Cvn'))
    //{
    //$greeting_message = i18n('News in draft: %1', '<a href="'.cn_url_modify('mod=editnews', 'source=draft').'"><b>'.$drafts.'</b></a>');
    //}
    //else
    //{
    //$greeting_message = i18n('Have a nice day!');
    //}

    //$nameset = 'bqngoc';
    //$nameset = $_SESSION['user_gamer'];

//    $greeting_message = 'Have a nice day!';
    cn_assign('dataNotifyForum, get_paging', @$item_read ? $item_read : array(), @$get_paging ? $get_paging : '');

    echoheader('-@home/style.css', "Home");
    echo exec_tpl('home/_public');
    echofooter();
}
