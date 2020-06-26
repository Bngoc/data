<?php
$odd = 0;
$i = 0;
$ok_loop = false;
$ok_loop2 = false;
list($item_read, $opt, $sub, $per_page, $pagination) = _GL('item_read, opt, sub, per_page, pagination');


cn_snippet_messages();
cn_snippet_bc();


?>

<div class="sub_guide">
    <div class="spa-1" style="padding-bottom: 3px; font-size:15px;">H? th?ng c?a hàng trang b? Game</div>

    <div id="ranking_search">
        <div id="select_search">
            <div id="sele_class" class="selectlayer" onclick="select.action(this,0,'hienthi');">
                <p><a href="#" class="default" onclick="return false;">......................</a></p>
                <ul>
                    <li><a href="#">................................</a></li>

                </ul>
            </div>
        </div>
    </div>

    <div class="panel">
        <?php cn_sort_menu($opt);
        echo '<div style="text-align: right;padding-right: 5px;    padding-top: 7px;">
		Entries on page:';
        foreach (array(25, 50, 100, 250) as $_per_page) {
            echo ' <a href="' . cn_url_modify('mod=cashshop', 'page', "per_page=$_per_page") . '" ' . ($per_page == $_per_page ? 'class="b"' : '') . '>' . $_per_page . '</a> ';
        }
        echo '<a style="color: #008080;" href="' . cn_url_modify('mod=cashshop', 'act=add_item') . '">[+ Thêm Item]</a>'; ?>
    </div>
</div>
<form action="<?php echo PHP_SELF; ?>" method="POST" accept-charset="utf-8">
    <?php cn_form_open('mod, opt'); ?>
    <table class="std-table opt_table">

        <tr>
            <th>#</th>
            <th>Ðồ vật</th>
            <th>Giá (V.Point)</th>
            <th>Hình</th>
            <th>Option</th>
        </tr>
        <?php //list($arr_item, $get_paging) = cn_render_pagination($item_read, 'mod=cashshop', $page, $per_page);
        //$paging = new PaginationTemplate(); $paging-> total = count($item_read); $paging-> cn_url_modify = 'mod=cashshop'; $paging-> page = 10; //onMouseOut="hidetip()" onMouseOver="Dshowtip(item[info])"
        if ($item_read) foreach ($item_read as $i => $var) {
            //for($i=0;$i<$stt;$i++) {
            //<tr <?php if ($odd++%2) echo ' style="background: #f8f8f8;"'; >
            echo '<tr';
            if ($i % 2) echo 'style="background: #f8f8f8;"';
            echo '><td align="center" style="vertical-align: middle;">' . ++$i . '</td>
			<td align="center" style="vertical-align: middle;">' . $var['title'] . '</td>
			<td align="center" style="vertical-align: middle;">' . number_format($var['price'], 0, ',', '.') . '</td>
			<td align="center" style="vertical-align: middle;"><img src="images/items/' . $var['image'] . '.gif" onMouseOut="hidetip()" onMouseOver="showtip(\'' . $var['info'] . '\')" /></td>
			<td align="center" style="vertical-align: middle;"><a href="admin.php?mod=editwebshop&act=.$act.&page=edit&item=$item_read[$i][stt] target="_self"">Sửa</a> / <a href="admin.php?mod=editwebshop&act=.$act.&page=del&item=".$item_read[$i][stt]." target="_self">Xóa</a></td>
		</tr>';
        }
        echo '</table>';
        echo $pagination; ?>

        <br/>
        <table class="panel wide">
            <tr>
                <td align="right" style="width: 10%;">Name <span class="required">*</span></td>
                <td><input style="width: 55%;" type="text" name="category_name"
                           value="<?php //echo ($category_name); ?>"/></td>
            </tr>

            <tr>
                <td align="right" valign="top" style="/*padding: 8px 0 0 0;*/">Price</td>
                <td><input style="width: 55%;" type="text" name="category_memo"
                           value="<?php //echo ($category_memo); ?>"/>
                    <div style="color: #888; margin: 0 0 8px 0;">(Vpoint)</div>
                </td>
            </tr>
            <tr>
                <td align="right">Code Item</td>
                <td><input style="width: 55%;" type="text" id="category_icon" name="category_icon"
                           value="<?php //echo ($category_icon); ?>"/>
                    <div style="color: #888; margin: 0 0 8px 0;">(32 Code get to MuMaker)</div>
                    <a class="external" href="#"
                       onclick="<?php //echo cn_snippet_open_win(cn_url_modify('mod=media','opt=inline','faddm=C','callback=category_icon'), array('w' => 640)); ?>">
                        Media manager
                    </a>
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <hr/>
                </td>
            </tr>

            <tr>
                <td>&nbsp;</td>
                <td>
                    <div style="float:left;">
                        <?php if (!$category_id) { ?>
                            <input type="submit" onclick="actionClick('a');" value="Add category"/>&nbsp;
                        <?php } else {
                            if (array_key_exists($category_id, $categories)) {
                                ?>
                                <input type="submit" onclick="actionClick('e');" value="Edit category"/>
                                &nbsp;
                                <input type="submit" onclick="actionClick('c');" value="Cancel edit"/>&nbsp;
                            <?php } else { ?>
                                <input type="submit" onclick="actionClick('c');" value="Cancel edit"/>&nbsp;
                            <?php }
                        } ?>
                    </div>
                    <div style="width:100%;text-align:right;">
                        <?php if ($category_id && array_key_exists($category_id, $categories)) { ?>
                            <input type="submit" onclick="actionClick('d');" value="Delete category"/>
                        <?php } ?>
                    </div>
                    <input type="hidden" id="mode" name="mode" value=""/>
                </td>
            </tr>

        </table>
        <script type="text/javascript">
            function actionClick(m) {
                var input = document.getElementById('mode');
                input.setAttribute('value', m);
            }
        </script>
</form>
