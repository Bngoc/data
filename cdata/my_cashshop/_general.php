<?php
$index = 0;
list($list_item, $token, $opt) = _GL('list_item, token, opt');
list($per_page) = _GL('per_page');


cn_snippet_messages();
?>

<div class="panel">
    <!--<table style="width: 100%" cellpadding="2">
		<tr>
			<td colspan="3" class="sub_title_1st" style="text-transform:uppercase;"><?php //echo $tilte ?><br/></td>
		</tr>
		<tr>
			<td colspan="3"><div class="vertical-img"><img src="<?php //echo $img_url; ?>/vertical-separator.jpg" width="640" height="1px" /></div><br/></td>
		</tr>
	</table> -->
    <table style="width: 100%">
        <tr>
            <td colspan=4><br></td>
        </tr>
        <tr>
            <?php if ($list_item) foreach ($list_item as $key => $raw) { ?>
                <td class="hh-w" valign="top" align="center">
                    <form method="POST" action="<?php echo PHP_SELF; ?>">
                        <?php cn_form_open('mod, token, opt');//echo cn_snippet_get_hidden();//?>
                        <input type="hidden" name="Item" value="<?php echo $key; ?>">
                        <table style="width: 150px;height: 170px;">
                            <tr class="h-ww" style="height: 105px;cursor: pointer;">
                                <td class="h-w" style="background-image: url(images/round.gif)" align="middle"
                                    valign="top"><img
                                        align="middle" <?php if ($raw['image_mh']) echo 'style="width: 80%;"'; else echo 'style=""'; ?>
                                        src="./images/<?php if ($raw['image_mh']) {
                                            echo 'shop_' . $opt . '/' . $raw['image_mh'];
                                        } else {
                                            echo 'items/' . $raw['image'] . '.gif';
                                        }
                                        echo '" title="' . $raw['title'] . '"'; ?> onMouseOut='UnTip()' onMouseOver="
                                        topxTip(document.getElementById('<?php echo $key; ?>').innerHTML)" />
                                    <div class="floatcontainer forumbit_nopost" id="<?php echo $key; ?>"
                                         style="display:none;background: rgba(0, 128, 0, 0.15);"><?php echo $raw['info'] ?></div>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center"><strong><?php echo $raw['title']; ?></strong></td>
                            </tr>
                            <tr>
                                <td style="text-align:center"><strong>Giá : <font
                                            color="#FF0000"><?php echo number_format($raw['price'], 0, ',', '.') ?>
                                            V.Point</font></strong></td>
                            </tr>
                            <tr>
                                <td style="text-align:center"><input type="image"
                                                                     style="cursor: url('<?php //echo $img_url ?>/mu2.cur'), auto;"
                                                                     <?php if (!isset($_SESSION['mu_Account'])) { ?>Onclick="return fnLoginAlert()"<?php }//kiem tra dang nhap?>
                                                                     src="./images/order.gif" width="80" height="25"/>
                                </td>
                            </tr>
                        </table>
                    </form>
                </td>
                <?php if ((++$index) % 4 == 0) {
                    echo '</tr><tr><td colspan=4><hr><br></td></tr><tr>';
                }
            } ?>
        </tr>
    </table>

    <?php
    echo '<div style="text-align: left;padding-right: 5px;margin-top: 12px;padding-top: 7px;">
		Entries on page:';
    foreach (array(12, 16, 24, 40, 60) as $_per_page) {
        echo ' <a href="' . cn_url_modify('mod=cash_shop', "token=$token", "opt=$opt", 'page', "per_page=$_per_page") . '" ' . ($per_page == $_per_page ? 'class="b"' : '') . '>' . $_per_page . '</a>';
    }
    echo '</div></div>';
    ?>
    <!-------------------------------------------------- -->
