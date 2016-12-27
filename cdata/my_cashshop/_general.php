<?php
$index = 0;
list($list_item, $token, $opt) = _GL('list_item, token, opt');
list($per_page, $echoPagination) = _GL('per_page, echoPagination');

?>
<div id="msg-Show"></div>
<div class="panel">
    <table style="width: 100%">
        <tr>
            <td colspan=4><br></td>
        </tr>
        <tr>
            <?php if ($list_item) foreach ($list_item as $key => $raw) { ?>
                <td class="hh-w" valign="top" align="center">
                    <form method="POST" <?php echo "action=" . PHP_SELF . "\" class=\"form-" . $key; ?>"
                    onsubmit="return false;">
                    <?php cn_form_open('mod, token, opt');//echo cn_snippet_get_hidden();//?>
                    <input type="hidden" name="item" value="<?php echo $key; ?>">
                    <table style="width: 150px;height: 170px;">
                        <tr class="h-ww" style="height: 105px;cursor: pointer;">
                            <td class="h-w" align="middle"
                                valign="top"><img
                                    align="middle" <?php if ($raw['image_mh']) echo 'style="width: 80%;"'; else echo 'style=""'; ?>
                                    src="./images/<?php if ($raw['image_mh']) {
                                        echo 'shop_' . $opt . '/' . $raw['image_mh'];
                                    } else {
                                        echo 'items/' . $raw['image'] . '.gif';
                                    }
                                    echo '" title="' . $raw['title'] . '"'; ?> onMouseOut='UnTip()'
                                         onMouseOver="topxTip(document.getElementById('<?php echo $key; ?>').innerHTML)" />
                                <div class="floatcontainer forumbit_nopost" id="<?php echo $key; ?>"
                                     style="display:none;background: rgba(0, 128, 0, 0.15);"><?php echo $raw['info'] ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center">
                                <strong class="infoName-<?php echo $key . "\">" . $raw['title']; ?></strong></td>
                            </tr>
                            <tr>
                                <td style=" text-align:center"><strong>Giá : <font color="#FF0000">
                                        <span class="infoPrice-<?php echo $key; ?>"><?php echo number_format($raw['price'], 0, ',', '.') ?></span>
                                        V.Point</font></strong>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center"><input id="<?php echo $key; ?>" class="call-Form-Shop"
                                                                 type="image" src="/images/order.gif" width="80"
                                                                 height="25"/></td>
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
    echo '<div class="col-left"><span>Entries on page: </span>';
    foreach (array(12, 16, 24, 40, 60) as $_per_page) {
        echo ' <a href="' . cn_url_modify('mod=cash_shop', "token=$token", "opt=$opt", 'page', "per_page=$_per_page") . '" ' . ($per_page == $_per_page ? 'class="b"' : '') . '>' . $_per_page . '</a>';
    }
    echo '</div>';
    echo "<div class=\"col-right pd-right5\">$echoPagination;</div>";
    ?>

</div>