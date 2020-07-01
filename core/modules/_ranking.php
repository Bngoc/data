<?php if (!defined('BQN_MU')) {
    die('Access restricted');
}

add_hook('index/invoke_module', '*ranking_invoke');

//=====================================================================================================================
function ranking_invoke()
{
    $ranking_board = array(
        'ranking:character:Ct' => 'Xếp Hạng Nhân vật',
        'ranking:rickCard:Ct' => 'Xếp Hạng Phú Hộ',
        'ranking:guild:Ct' => 'Xếp Hạng Bang Hội'
    );

    // Call dashboard extend
    $ranking_board = hook('extend_dashboard', $ranking_board);

    // Exec
    $mod = REQ('mod', 'GETPOST');
    $opt = REQ('opt', 'GETPOST');

    // Top level (dashboard)
    cn_bc_add('Xếp hạng', cn_url_modify(array('reset'), 'mod=' . $mod));

    foreach ($ranking_board as $id => $_t) {
        list($dl, $do, $acl_module) = explode(':', $id);
        if (function_exists("ranking_$do")) {
            cn_bc_menu($_t, cn_url_modify(array('reset'), 'mod=' . $dl, 'opt=' . $do), $do);
        }
    }

    // Request module
    foreach ($ranking_board as $id => $_t) {
        list($dl, $do, $acl_module) = explode(':', $id);
        //if (testRoleWeb($acl_module) && $dl == $mod && $do == $opt && function_exists("ranking_$do")) {
        if ($dl == $mod && $do == $opt && function_exists("ranking_$do")) {
            cn_bc_add($_t, cn_url_modify(array('reset'), 'mod=' . $mod, 'opt=' . $opt));
            die(call_user_func("ranking_$opt"));
        }

        if ($dl == $mod && $do == $opt && !function_exists("ranking_$do")) {
            cn_bc_add('Lỗi dữ liệu', cn_url_modify(array('reset'), 'mod=' . $mod, 'opt=' . $do));
            die(call_user_func("ranking_default"));
        }
    }

    $images = array(
        'character' => 'character.png',
        'rickCard' => 'classRickCard.png',
        'guild' => 'guild.png',
//        'month' => 'month.png'
    );

//    // More dashboard images
//    $images = hook('extend_dashboard_images', $images);

    foreach ($ranking_board as $id => $name) {
        list($mod, $act, $acl) = explode(':', $id);

        //if (!testRoleWeb($acl)) {
        // unset($relax_board[$id]);
        //continue;
        //}

        $item = array(
            'name' => $name,
            'img' => isset($images[$act]) ? $images[$act] : 'home.gif',
            'mod' => $mod,
            'opt' => $act
        );

        $ranking_board[$id] = $item;
    }

    cn_assign('dashboard', $ranking_board);
    echo_header_web('-@my_ranking/style.css', "Xếp hạng");
    echo_content_here(exec_tpl('my_ranking/general'), cn_snippet_bc_re());
    echo_footer_web();
}

function ranking_default()
{
    $arr_shop = getMemcache('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echo_header_web('defaults/style.css', "Error - $name__");
    echo_content_here(exec_tpl('defaults/default'), cn_snippet_bc_re());
    echo_footer_web();
}

function zenderRankingCharacter($class, $url, $page, $optSort = 'DESC')
{
    $tempClass = cn_template_class();
    $per_page = 50;

    $keyClass = strtolower($class);
    $keyClassList = '';
    foreach ($tempClass as $k => $items) {
        $isKey = explode('_', $k);
        $isCheckOpt4 = isset($isKey[3]) ? true : false;
        $strKeymere = $isKey[0] . '_' . $isKey[1];
        if ($keyClass == $strKeymere && !$isCheckOpt4) {
            $keyClassList .= $items . ',';
        }
    }

    if (!empty($class) && $class == 'class_none') {
        $keyClass = '';
    } else {
        $keyClassList .= '-1';
        $keyClass = "WHERE class IN ($keyClassList)";
    }
    //if (strlen($keyClassList) > 0) $keyClassList = substr($keyClassList, 0, -1);

    $myQuerydataTop = "SELECT TOP 250 Character.AccountID, Character.Name, Character.cLevel, Character.Class, Character.Resets, Character.Relifes, Character.DGT_Time, AccountCharacter.GameIDC, MEMB_STAT.ConnectStat,";
    $myQuerydataTop .= " (Character.Dexterity + Character.Energy + Character.Leadership + Character.Strength + Character.Vitality) as totalPoint";
    $myQuerydataTop .= " FROM Character LEFT JOIN AccountCharacter ON Character.AccountID = AccountCharacter.Id LEFT JOIN MEMB_STAT ON Character.AccountID = MEMB_STAT.memb___id";
    $myQuerydataTop .= " $keyClass ORDER BY Character.[Relifes] $optSort, Character.[Resets] $optSort, Character.[cLevel] $optSort";

    $dataTop = do_select_other($myQuerydataTop);

    list($resultShowData, $pagination) = cn_render_pagination_ajax($dataTop, $url, $page, $per_page);

    foreach ($resultShowData as $key => $item) {
        $getKey = array_search($item['Class'], $tempClass);

        $detailClass = '---';
        if ($getKey !== false) {
            $getKey .= '_name';
            $detailClass = $tempClass[$getKey];
        }

        $checkMemberStart = 0;
        if ($item['Name'] == $item['GameIDC'] && $item['ConnectStat']) {
            $checkMemberStart = 1;
        }

        $resultShowData[$key]['statusOnline'] = $checkMemberStart;
        $resultShowData[$key]['showNameClass'] = $detailClass;
    }

    return array($resultShowData, $pagination);
}

function zenderRankingGuild($sub, $url, $page, $optSort = 'DESC')
{
    $per_page = 50;
    $resultTopGuild = do_select_other("select top 20 COUNT(*) as count, Guild.G_Name, Guild.G_Master from MuOnline.dbo.GuildMember, MuOnline.dbo.Guild where GuildMember.G_Name = Guild.G_Name group by Guild.G_Name, G_Master order by count $optSort");
    $arrGuild = array();
    $strQueryClause = '';
    foreach ($resultTopGuild as $ds => $vl) {
        $arrGuild[$vl['G_Name']] = $vl;
        $strQueryClause .= "'" . $vl['G_Name'] . "',";
    }

    if (empty($resultTopGuild)) {
        return array(array(), '');
    }

//    $strQueryClause .= implode(',', array_column($resultTopGuild, 'G_Name'));

    $myQuery = "SELECT TOP 250 GuildMember.G_Name, Character.Name, Character.Relifes, Character.Resets, Character.cLevel";
    $myQuery .= " FROM MuOnline.dbo.Character LEFT JOIN MuOnline.dbo.GuildMember on GuildMember.Name = Character.Name";
    $myQuery .= (strlen($strQueryClause) > 0) ? " WHERE GuildMember.G_Name IN (" . substr($strQueryClause, 0, -1) . ")" : '';
    $myQuery .= " order by GuildMember.G_Name $optSort, Relifes DESC, Resets DESC, cLevel DESC";

    $resultData = do_select_other($myQuery);
    $tempRl = false;
    $tempGuild = '';
    foreach ($resultData as $ke => $item) {
        if ($tempGuild != $item['G_Name']) {
            $tempGuild = $item['G_Name'];
            $tempRl = false;
        }

        if (in_array($item['G_Name'], $arrGuild[$item['G_Name']])) {
            $arrGuild[$item['G_Name']]['totalReset'] = $item['Resets'] + (isset($arrGuild[$item['G_Name']]['totalReset']) ? $arrGuild[$item['G_Name']]['totalReset'] : 0);
            $tempGuild = $item['G_Name'];

            if (!$tempRl) {
                $arrGuild[$item['G_Name']]['strongClassGuils'] = $item['Name'];
                $arrGuild[$item['G_Name']]['Resets'] = $item['Resets'];
                $arrGuild[$item['G_Name']]['Relifes'] = $item['Relifes'];
                $arrGuild[$item['G_Name']]['cLevel'] = $item['cLevel'];
                $tempRl = true;
            }
        }
    }

    $showData = array();
    foreach ($arrGuild as $key => $its) {
        $showData[] = $its;
    }

    // Top Reset
    if ($sub == 'class_1') {
        if ($optSort == 'DESC') {
            usort($showData, function ($a, $b) {
                return $b['totalReset'] - $a['totalReset'];
            });
        } else {
            usort($showData, function ($a, $b) {
                return $a['totalReset'] - $b['totalReset'];
            });
        }
    }

    list($resultShowData, $pagination) = cn_render_pagination_ajax($showData, $url, $page, $per_page);

    return array($resultShowData, $pagination);
}

function zenderRankingCard($opts, $url, $page, $optSort = 'DESC')
{
    $per_page = 50;
    $whereOpt = '';
    $opts = explode('_', $opts)[1];
    if (strtolower($opts) && $opts != 'none') {
        $whereOpt = 'WHERE card_type= \'' . strtolower($opts) . '\'';
    }
    $resultTopCard = do_select_other("select TOP 250 accountID, SUM(menhgia) as total_vnd from muonline.dbo.cardphone $whereOpt group by accountID order by total_vnd $optSort");

    list($resultShowData, $pagination) = cn_render_pagination_ajax($resultTopCard, $url, $page, $per_page);

    return array($resultShowData, $pagination);
}

function zenderDataContent($dataResult)
{
    $dataTableResult = '<table class="pd-top5 ranking" width="100%">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Level</th>
            <th>Relife / Reset</th>
            <th>Point</th>
            <th>Class</th>
            <th>ChangeClass</th>
            <th>Status</th>
        </tr>';

    if ($dataResult) {
        foreach ($dataResult as $key => $items) {
            $dataTableResult .= '<tr><td>' . ($key + 1) . '</td>';
            $dataTableResult .= '<td>' . ucfirst($items['Name']) . '</td>';
            $dataTableResult .= '<td>' . $items['cLevel'] . '</td>';
            $dataTableResult .= '<td>' . $items['Relifes'] . ' / ' . $items['Resets'] . '</td>';
            $dataTableResult .= '<td>' . $items['totalPoint'] . '</td>';
            $dataTableResult .= '<td>' . $items['showNameClass'] . '</td>';
            $dataTableResult .= '<td>' . (@$items['DGT_Time'] ? date('d-M-Y h:ia', $items['DGT_Time']) : '---') . '</td>';
            $dataTableResult .= '<td><img src="/public/images/' . (@$items['statusOnline'] ? 'users_online' : 'users_offline') . '.gif" alt="' . (@$items['ConnectStat'] ? 'Online' : 'Offline') . '"></td></tr>';
        }
    }

    $dataTableResult .= '</table>';

    return $dataTableResult;
}

function zenderDataContentCardRich($dataResult)
{
    $dataTableResult = '<table class="pd-top5 ranking" width="100%">
        <tr>
            <th>#</th>
            <th>Tài khoản</th>
            <th>Tổng VND</th>
            <!--<th>Relife / Reset</th>
            <th>Point</th>
            <th>Class</th>
            <th>ChangeClass</th>
            <th>Status</th> -->
        </tr>';

    if ($dataResult) {
        foreach ($dataResult as $key => $items) {
            $dataTableResult .= '<tr><td>' . ($key + 1) . '</td>';
            $dataTableResult .= '<td>' . ucfirst($items['accountID']) . '</td>';
//            $dataTableResult .= '<td>' . $items['cLevel'] . '</td>';
//            $dataTableResult .= '<td>' . $items['Relifes'] . ' / ' . $items['Resets'] . '</td>';
//            $dataTableResult .= '<td>' . 0 . '</td>';
//            $dataTableResult .= '<td>' . 0 . '</td>';
//            $dataTableResult .= '<td>' . 0 . '</td>';
            $dataTableResult .= '<td>' . number_format($items['total_vnd'], 0, ',', '.') . '</td></tr>';
        }
    }
    $dataTableResult .= '</table>';

    return $dataTableResult;
}

function zenderDataContentGuild($dataResult)
{
    $dataTableResult = '<table class="pd-top5 ranking" width="100%">
        <tr>
			<th class="lbg">Hạng</th>
			<th>Tên Hội</th>
			<th>Chủ Hội</th>
			<th>Thành viên</th>
			<th>Reset Tổng</th>
			<th class="rbg"><span>Mạnh Nhất (Reset)</span></th>
		</tr>';

    if ($dataResult) {
        foreach ($dataResult as $key => $items) {
            $dataTableResult .= '<tr><td>' . ($key + 1) . '</td>';
            $dataTableResult .= '<td>' . $items['G_Name'] . '</td>';
            $dataTableResult .= '<td>' . $items['G_Master'] . '</td>';
            $dataTableResult .= '<td>' . $items['count'] . '</td>';
            $dataTableResult .= '<td>' . $items['totalReset'] . '</td>';
            $dataTableResult .= '<td>' . $items['strongClassGuils'] . ' (' . $items['Relifes'] . 'RL / ' . $items['Resets'] . ' R/ ' . $items['cLevel'] . 'Lv)' . '</td></tr>';
        }
    }
    $dataTableResult .= '</table>';

    return $dataTableResult;
}

function ranking_character()
{
    list($sub, $sort, $page) = GET('sub, sort, page', "GETPOST");
    $class_board = array(
        'class_none' => 'All',
        'class_dk' => 'Dark Kni...',
        'class_dl' => 'Dark Lor...',
        'class_dw' => 'Dark Wiz...',
        'class_elf' => 'Elf',
        'class_mg' => 'Magic Gla..',
        'class_sum' => 'Summoner',
        'class_rf' => 'Rage Fig...'
    );

    if (empty($sub)) {
        $sub = 'class_none';
    }
    if (empty($sort)) {
        $sort = 'desc';
    }
    if (empty($page) || $page <= 0) {
        $page = 1;
    }
    $url = cn_url_modify(array('reset'), 'mod=ranking', 'opt=character', 'sub=' . $sub, 'sort=' . strtolower($sort), 'per_page', 'page');

    if (request_type('GET')) {
        if (isset($_REQUEST['sub'])) {
            list($arrRankingCharater, $pagination) = zenderRankingCharacter($sub, $url, $page, strtoupper($sort));

            $resultData = array(
                'id-sub' => $sub,
                'id-sort' => $sort,
                'result_content' => zenderDataContent($arrRankingCharater),
                'result_pagination' => $pagination
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }

    list($arrRankingCharater, $pagination) = zenderRankingCharacter($sub, $url, $page, strtoupper($sort));

    cn_assign('opt', 'character');
    cn_assign('class_board, sub, pagination, sort, result_content', $class_board, $sub, $pagination, $sort, zenderDataContent($arrRankingCharater));
    echo_header_web('-@my_ranking/style.css@my_ranking/callAjaxRanking.js', "Bảng xếp hạng theo nhân vật");
    echo_content_here(exec_tpl('my_ranking/_ranking'), cn_snippet_bc_re());
    echo_footer_web();
}

function ranking_guild()
{
    list($sub, $sort, $page) = GET('sub, sort, page', "GETPOST");
    $class_board = array(
        'class_0' => 'Top Reset',
        'class_1' => 'Top Member'
    );

    if (empty($sub)) {
        $sub = 'class_0';
    }
    if (empty($sort)) {
        $sort = 'desc';
    }
    if (empty($page) || $page <= 0) {
        $page = 1;
    }
    $url = cn_url_modify(array('reset'), 'mod=ranking', 'sub=' . $sub, 'opt=guild', 'sort=' . strtolower($sort), 'per_page', 'page');

    if (request_type('GET')) {
        if (isset($_REQUEST['sub'])) {
            list($arrRankingCharater, $pagination) = zenderRankingGuild($sub, $url, $page, strtoupper($sort));

            $resultData = array(
                'id-sub' => $sub,
                'id-sort' => $sort,
                'result_content' => zenderDataContentGuild($arrRankingCharater),
                'result_pagination' => $pagination
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }

    list($arrRankingCharater, $pagination) = zenderRankingGuild($sub, $url, $page, strtoupper($sort));

    cn_assign('opt', 'guild');
    cn_assign('class_board, sub, pagination, sort, result_content', $class_board, $sub, $pagination, $sort, zenderDataContentGuild($arrRankingCharater));
    echo_header_web('-@my_ranking/style.css@my_ranking/callAjaxRanking.js', "Bảng xếp hạng Bang Hội");
    echo_content_here(exec_tpl('my_ranking/_ranking'), cn_snippet_bc_re());
    echo_footer_web();
}

function ranking_rickCard()
{
    list($sub, $sort, $page) = GET('sub, sort, page', "GETPOST");
    $class_board = array();

    $class_board = array(
        'class_none' => 'All',
        'class_gate' => 'Gate',
        'class_mobi' => 'Mobifone',
        'class_vina' => 'VinaPhone',
        'class_viettel' => 'Viettel',
        'class_vtc' => 'Vtc'
    );
    if (empty($sub)) {
        $sub = 'class_none';
    }
    if (empty($sort)) {
        $sort = 'desc';
    }
    if (empty($page) || $page <= 0) {
        $page = 1;
    }

    $url = cn_url_modify(array('reset'), 'mod=ranking', 'opt=rickCard', 'sub=' . $sub, 'sort=' . strtolower($sort), 'per_page', 'page');

    if (request_type('GET')) {
        if (isset($_REQUEST['sub'])) {
            list($arrRankingCharater, $pagination) = zenderRankingCard($sub, $url, $page, strtoupper($sort));

            $resultData = array(
                'id-sub' => $sub,
                'id-sort' => $sort,
                'result_content' => zenderDataContentCardRich($arrRankingCharater),
                'result_pagination' => $pagination
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }

    list($arrRankingCharater, $pagination) = zenderRankingCard($sub, $url, $page, strtoupper($sort));

    cn_assign('opt', 'rickCard');
    cn_assign('class_board, sub, pagination, sort, result_content', $class_board, $sub, $pagination, $sort, zenderDataContentCardRich($arrRankingCharater));
    echo_header_web('-@my_ranking/style.css@my_ranking/callAjaxRanking.js', "Bảng xếp hạng Phú Hội");
    echo_content_here(exec_tpl('my_ranking/_ranking'), cn_snippet_bc_re());
    echo_footer_web();
}
