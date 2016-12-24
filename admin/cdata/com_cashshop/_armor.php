<?php
$odd = 0;
$ok_loop = false;
$ok_loop2 = false;
list($item_read, $opt, $sub, $per_page, $pagination) = _GL('item_read, opt, sub, per_page, pagination');
list($_id, $_txt_name, $_txt_price, $_txt_code32, $_txt_image) = _Gl('_id, _txt_name, _txt_price, _txt_code32, _txt_image');

cn_snippet_messages();
cn_snippet_bc();

?>

<div class="panel">
    <?php cn_sort_menu($opt);
    echo '<div style="text-align: right;padding-right: 5px;    padding-top: 7px;">
		Entries on page:';
    foreach (array(5, 10, 15, 25, 30, 50, 75, 100, 250) as $_per_page) {
        echo ' <a href="' . cn_url_modify('mod=cashshop', 'do=action', "opt=$opt", 'page', '_id', '__item', "per_page=$_per_page") . '" ' . ($per_page == $_per_page ? 'class="b"' : '') . '>' . $_per_page . '</a> ';
    }
    echo ' <a href="' . cn_url_modify('mod=cashshop', 'do=action', "opt=$opt", 'page', '_id', 'per_page', '__item=change-item') . '" title="Read file name \'shop_' . $opt . '.php\'"><b>[+]</b>-Add Item</a> -- <a href="' . cn_url_modify('mod=cashshop', 'do=action', "opt=$opt", 'page', '_id', 'per_page', '__item=del-item') . '" title="Delete all code item"><b>[x]</b>-Del all</a>'; ?>
</div>
</div>

<table class="std-table opt_table">
    <tr>
        <th>#</th>
        <th>Ðồ vật</th>
        <th>Giá (V.Point)</th>
        <th>Hình</th>
        <th>Thông tin</th>
        <th>Hình minh họa</th>
    </tr>
    <?php if ($item_read) foreach ($item_read as $key => $var) {
        $var_info = $var['info'];
        echo '<tr';
        if ($key == $_id) echo ' class="row_selected"';
        else if ($key % 2) echo ' style="background: #f8f8f8;"';

        echo '><td align="center" style="vertical-align: middle;">' . $key . '</td>
				<td align="center" style="vertical-align: middle;"><a href="' . cn_url_modify('mod=cashshop', 'do=action', "opt=$opt", '__item', "_id=$key") . '">' . $var['name'] . '</a></td>
				<td align="center" style="vertical-align: middle;">' . number_format($var['price'], 0, ',', '.') . '</td>
				<td align="center" style="vertical-align: middle;"><img src="images/items/' . $var['image'] . '.gif" onMouseOut=UnTip() onMouseOver="topxTip(document.getElementById(\'' . $key . '\').innerHTML)" >
					<div class="floatcontainer forumbit_nopost" id="' . $key . '" style="display:none;background: rgba(0, 128, 0, 0.15);">' . $var['info'] . '</div>
				</td>
				<td align="center" style="vertical-align: middle;">' . $var_info . ' </td>
				<td align="center" style="vertical-align: middle;"><img width=100px height=100px title="' . $var['title'] . '" src="images/shop_' . $opt . '/';
        if (!$var['image_mh']) echo '-----'; else echo $var['image_mh'];
        echo '">
				
				
				</td>
				
			</tr>';
    }
    else
        echo '<tr><td colspan="6" style="text-align: center;">No one Item exists</td> </tr>';
    echo '</table>';
    echo $pagination; ?>

    <br/>

    <form action="<?php echo PHP_SELF; ?>" method="POST" accept-charset="utf-8">
        <?php cn_form_open('mod, do, opt'); ?>
        <input type="hidden" name="_id" value="<?php echo $_id; ?>"/>

        <table class="panel wide">
            <tr>
                <td align="right" style="width: 10%;">Name <span class="required">*</span></td>
                <td><input style="width: 55%;" type="text" name="txt_name" placeholder="Wing Of Dimension"
                           value="<?php echo($_txt_name); ?>"/></td>
            </tr>
            <tr>
                <td align="right">Code Item <span class="required">*</span></td>
                <td><input style="width: 55%;float: left;" type="text" id="category_icon" name="txt_code32"
                           placeholder="0D0096FC1E7A000000E0000000000000" value="<?php echo($_txt_code32); ?>"/>
                    <div style="color: #888; margin: 0 0 8px 0;float: left;margin-left: 5px;">(32 Code get to MuMaker)
                    </div>
                    <!--<a class="external" href="#" onclick="<?php //echo cn_snippet_open_win(cn_url_modify('mod=media','opt=inline','faddm=C','callback=category_icon'), array('w' => 640)); ?>">
						Media manager
					</a> -->
                </td>
            </tr>
            <tr>
                <td align="right" valign="top" style="/*padding: 8px 0 0 0;*/">Price</td>
                <td><input style="width: 55%;float: left;" type="number" name="txt_price" min="0" placeholder="100000"
                           value="<?php echo($_txt_price); ?>"/>
                    <div style="color: #888; margin: 0 0 8px 0;float: left;margin-left: 5px;">(Vpoint)</div>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top" style="/*padding: 8px 0 0 0;*/">Image Item</td>
                <td><input style="width: 55%;float: left;" type="txt" name="txt_image" min="0" placeholder="image.gif"
                           value="<?php echo($_txt_image); ?>"/>
                    <div style="color: #888; margin: 0 0 8px 0;float: left;margin-left: 5px;"></div>
                </td>
            </tr>
            <tr><td></td><td><hr/></td></tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <div style="float:left;">
                        <?php if (!$_id) { ?>
                            <input type="submit" onclick="actionClick('a');" value="Add category"/>&nbsp;
                        <?php } else {
                            if (array_key_exists($_id, $item_read)) {
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
                        <?php if ($_id && array_key_exists($_id, $item_read)) { ?>
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