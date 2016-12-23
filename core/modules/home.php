<?php if (!defined('BQN_MU')) die('Access restricted');

add_hook('index/invoke_module', '*home_invoke');

// =====================================================================================================================

function home_invoke()
{
    $per_page = 15;
    $page = intval(REQ('page', 'GETPOST'));
    if (empty($page)) $pageLimit = 0;

    if ($page != 0) $pageLimit = ($page - 1) * $per_page;

    $result_Count_F = do_select_ortherForum("SELECT COUNT(*) as numCount FROM thread WHERE open = 1 AND postuserid IN (SELECT userid from user where usergroupid in (5,6,7,9))");
    $countNotifyForum = $result_Count_F[0]['numCount'];

    if ($countNotifyForum > 50) $countNotifyForum = 50;
    if ($countNotifyForum) {
        $myQuery_F = 'SELECT thread.threadid, thread.title, thread.prefixid, thread.postuserid, thread.postusername, thread.lastpost, thread.keywords, usergroup.title as titleUser  FROM thread, user, usergroup WHERE open = 1 AND postuserid in (select userid from user where usergroupid in (5,6,7,9)) AND thread.postuserid = user.userid AND user.usergroupid = usergroup.usergroupid order by lastpost desc limit ' . $pageLimit . ',' . $per_page . ';';
        $dataNotifyForum = do_select_ortherForum($myQuery_F);

        foreach ($dataNotifyForum as $key => $item) {
            $dataNotifyForum[$key]['urlForum'] = ewConvertFromUtf8($item['title']);
            $keywords = str_replace(',', '', $item['title']);
            if (strlen($keywords) > 45) {
                $keywords = substr($keywords, 0, 45) . '...';
            }
            $dataNotifyForum[$key]['title'] = $keywords;

            if (preg_match('/^tb/', $item['prefixid'])) $dataNotifyForum[$key]['nameColor'] = 'tb';
            else $dataNotifyForum[$key]['nameColor'] = 'garena';
        }

        $item_read = $dataNotifyForum;
        $get_paging = cn_countArr_pagination($countNotifyForum, cn_url_modify(array('reset')), $page, $per_page);
    }

    //Ranking top 10
    $result_RankingTop10 = do_select_orther("SELECT TOP 10 [Name], [AccountID],[cLevel],[Class],[Resets],[Relifes] FROM [MuOnline].[dbo].[Character] ORDER BY Relifes desc, Resets desc, cLevel desc");

    cn_assign('dataNotifyForum, get_paging, result_RankingTop10', @$item_read ? $item_read : array(), @$get_paging ? $get_paging : '', $result_RankingTop10);

    echoheader('-@home/style.css', "Home");
    echo exec_tpl('home/_public');
    echofooter();
}
