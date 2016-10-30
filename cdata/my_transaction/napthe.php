<?php

list($showchar, $card_list) = _GL('showchar, card_list');

cn_snippet_messages();
?>

<form method="post" name="frmnapthe" action="index.php?module=napthe&type=<?php //echo $type ?>"
      onSubmit="return CheckFormNapThe();">
    <!--
<div class="sub_guide">
<?php //if ($khuyenmai) {?>
<div class="sub_ranking">
	<table id="tbl_regist">
		<colgroup>
			<col width="250" />
			<col width="450" />
		</colgroup>
		<thead>
		<tr>
			<th class="lbg">Chương trình khuyến mại thẻ nạp:</th>
			<th class="rbg"><?php //echo $khuyenmai_phantram ?> % cho bất kì mệnh giá nào</th>
		</tr>
		</thead>
	</table>
</div>
<!--
<?php //}?>
<div id="ranking_search">
	<div id="select_search">
		<div id="sele_class" class="selectlayer" onclick="select.action(this,0,'hienthi');">
			<p><a href="#" class="default" onclick="return false;"><?php //echo $title_top; ?></a></p>
			<ul>
				<?php //if ($use_napcard_vtc) {?><li><a href="index2.php?module=napthe&type=VTC">Nạp thẻ VTC</a></li><?php //}?>
				<?php //if ($use_napcard_gate) {?><li><a href="index2.php?module=napthe&type=Gate">Nạp thẻ Gate</a></li><?php //}?>
				<?php //if ($use_napcard_viettel) {?><li><a href="index2.php?module=napthe&type=Viettel">Nạp thẻ Viettel</a></li><?php //}?>
				<?php //if ($use_napcard_mobi) {?><li><a href="index2.php?module=napthe&type=Mobi">Nạp thẻ Mobi</a></li><?php //}?>
				<?php //if ($use_napcard_vina) {?><li><a href="index2.php?module=napthe&type=Vina">Nạp thẻ Vina</a></li><?php //}?>
			</ul>
		</div>
	</div>
</div>-->
    <input type="hidden" name="CardType" value="<?php //echo $type ?>"/>
    <table style="width: 100%" cellpadding="2">
        <tr>
            <td colspan="3" class="sub_title_1st">THÔNG TIN TÀI KHOẢN<br/>Chương trình khuyến mại thẻ
                nạp:<?php //echo $khuyenmai_phantram ?> % cho bất kì mệnh giá nào
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php //echo $img_url; ?>/vertical-separator.jpg" width="640"
                                               height="1px"/></div>
                <br/></td>
        </tr>
        <?php //if (isset($_SESSION['mu_Account'])) {?>
        <tr>
            <td class="bizwebform_col_1">Tên tài khoản</td>
            <td class="bizwebform_col_2"
                style="padding-left:20px; color:#FF9933; font-weight:bold"><?php //echo $_SESSION['mu_Account'] ?></td>
            <td class="bizwebform_col_3" id="UserID"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Số Vpoint hiện có</td>
            <td class="bizwebform_col_2"
                style="padding-left:20px; color:#FF9933; font-weight:bold"><?php //echo number_format($vpoint,0,",","."); ?>
                V.Point
            </td>
            <td class="bizwebform_col_3"></td>
        </tr>
        <?php //}else{?>
        <tr>
            <td class="bizwebform_col_1">Nhập tên tài khoản</td>
            <td class="bizwebform_col_2"><input name="Account" id="bizwebform" type="text" maxlength="10"
                                                autocomplete="off" onchange="findUser(this.value);"/></td>
            <td class="bizwebform_col_3" id="UserID"></td>
        </tr>
        <?php //}?>
        <tr>
            <td class="bizwebform_col_1">Serial</td>
            <td class="bizwebform_col_2"><input name="CardSerial" id="bizwebform" type="text" maxlength="12"
                                                autocomplete="off" onchange="checkCardSerial(this.value);"
                                                value="<?php //if ($type == "VTC") echo "PM"; ?>"/></td>
            <td class="bizwebform_col_3" id="CardSerialID"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Mã số thẻ</td>
            <td class="bizwebform_col_2"><input name="CardCode" id="bizwebform" type="text" maxlength="14"
                                                autocomplete="off" onchange="checkCardCode(this.value);"/></td>
            <td class="bizwebform_col_3" id="CardCodeID"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Mệnh giá thẻ</td>
            <td class="bizwebform_col_2">
                <select size="1" name="Denominations" id="bizwebselect" onchange="checkDenominations(this.value);">
                    <option value="" selected="selected"> -- Chọn mệnh giá thẻ nạp --</option>
                    <?php if ($card_list) foreach ($card_list as $id => $val) {
                        echo '<option value="' . $id . '"> Thẻ ' . number_format($val, 0, ",", ".") . ' VNĐ</option>';
                    } ?>
                </select>
            </td>
            <td class="bizwebform_col_3" id="DenominationsID"></td>
        </tr>
        <tr>
            <td colspan="3" class="sub_title_1st"><br/>MÃ XÁC NHẬN</td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php //echo $img_url; ?>/vertical-separator.jpg" width="640"
                                               height="1px"/></div>
                <br/></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Code Image</td>
            <td class="bizwebform_col_2" style="padding-left:20px;"><img src="img.php?size=6"/></td>
            <td class="bizwebform_col_3"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Nhập mã xác nhận</td>
            <td class="bizwebform_col_2"><?php //$vImage->showCodBox(1); ?></td>
            <td class="bizwebform_col_3" id="msg_vImageCodP"></td>
        </tr>
        <tr>
            <td colspan="3" style="padding:20px; text-align:center"></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align:center">
                <input type="hidden" value="napthe" name="action"/>
                <input type="image" src="<?php //echo $img_url; ?>/capnhat.png" style="padding-right:10px">
                <img style="cursor:pointer" border="0" src="<?php //echo $img_url; ?>/cancel.png"
                     style="padding-left:10px">
            </td>
        </tr>
    </table>

</form>
<?php //if (isset($_SESSION['mu_Account'])) {?>
<table style="width: 100%" cellpadding="2">
    <tr>
        <td colspan="3" style="padding:20px; text-align:center"></td>
    </tr>
    <tr>
        <td colspan="3" class="sub_title_1st">DANH SÁCH THẺ ĐÃ NẠP<br/></td>
    </tr>
    <tr>
        <td colspan="3">
            <div class="vertical-img"><img src="<?php //echo $img_url; ?>/vertical-separator.jpg" width="640"
                                           height="1px"/></div>
            <br/></td>
    </tr>
</table>
<div class="sub_ranking">
    <table id="tbl_ranking">
        <colgroup>
            <col width="50"/>
            <col width="100"/>
            <col width="150"/>
            <col width="150"/>
            <col width="100"/>
            <col width="150"/>
        </colgroup>
        <thead>
        <tr>
            <th class="lbg">TT</th>
            <th>Loại thẻ</th>
            <th>Mã thẻ</th>
            <th>Serial</th>
            <th>Ngày nạp</th>
            <th class="rbg"><span>Tình trạng</span></th>
        </tr>
        </thead>
        <tbody>
        <?php //if (!is_array($cardphone) && !is_object($cardphone)) settype($cardphone, 'array'); foreach ($cardphone as $cardphone) {?>
        <tr>
            <td><?php //echo $cardphone[stt] ?></td>
            <td><?php //echo $cardphone[card_type] ?></td>
            <td><?php //echo $cardphone[card_num] ?></td>
            <td><?php //echo $cardphone[card_serial] ?></td>
            <td><?php //echo $cardphone[card_time] ?></td>
            <td><?php //echo $cardphone[card_status] ?></td>
        </tr>
        <?php //}?>
        </tbody>
    </table>
</div>
<?php //}?>
<table style="width: 100%" cellpadding="2">
    <tr>
        <td colspan="3" style="padding:20px; text-align:center"></td>
    </tr>
    <tr>
        <td colspan="3" class="sub_title_1st">THÔNG TIN TRỊ GIÁ<br/></td>
    </tr>
    <tr>
        <td colspan="3">
            <div class="vertical-img"><img src="<?php //echo $img_url; ?>/vertical-separator.jpg" width="640"
                                           height="1px"/></div>
            <br/></td>
    </tr>
</table>
<div class="sub_ranking">
    <table id="tbl_ranking">
        <colgroup>
            <col width="350"/>
            <col width="350"/>
        </colgroup>
        <thead>
        <tr>
            <th class="lbg">Mệnh giá (VNĐ)</th>
            <th class="rbg"><span>V.Point</span></th>
        </tr>
        </thead>
        <tbody>
        <?php //if ($use_card10k) {?>
        <tr>
            <td>10.000</td>
            <td><?php //echo number_format($menhgia10000,0,",",".") ?></td>
        </tr>
        <?php //}?>
        <?php //if ($use_card20k) {?>
        <tr>
            <td>20.000</td>
            <td><?php //echo number_format($menhgia20000,0,",",".") ?></td>
        </tr>
        <?php //}?>
        <?php //if ($use_card30k) {?>
        <tr>
            <td>30.000</td>
            <td><?php //echo number_format($menhgia30000,0,",",".") ?></td>
        </tr>
        <?php //}?>
        <?php //if ($use_card50k) {?>
        <tr>
            <td>50.000</td>
            <td><?php //echo number_format($menhgia50000,0,",",".") ?></td>
        </tr>
        <?php //}?>
        <?php //if ($use_card100k) {?>
        <tr>
            <td>100.000</td>
            <td><?php //echo number_format($menhgia100000,0,",",".") ?></td>
        </tr>
        <?php //}?>
        <?php //if ($use_card200k) {?>
        <tr>
            <td>200.000</td>
            <td><?php //echo number_format($menhgia200000,0,",",".") ?></td>
        </tr>
        <?php //}?>
        <?php //if ($use_card300k) {?>
        <tr>
            <td>300.000</td>
            <td><?php //echo number_format($menhgia300000,0,",",".") ?></td>
        </tr>
        <?php //}?>
        <?php //if ($use_card500k) {?>
        <tr>
            <td>500.000</td>
            <td><?php //echo number_format($menhgia500000,0,",",".") ?></td>
        </tr>
        <?php //}?>
        </tbody>
    </table>
</div>
<table style="width: 100%" cellpadding="2">
    <tr>
        <td colspan="3" style="padding:20px; text-align:center"></td>
    </tr>
    <tr>
        <td colspan="3" class="sub_title_1st">GIỚI HẠN THẺ NẠP<br/></td>
    </tr>
    <tr>
        <td colspan="3">
            <div class="vertical-img"><img src="<?php //echo $img_url; ?>/vertical-separator.jpg" width="640"
                                           height="1px"/></div>
            <br/></td>
    </tr>
</table>
<div class="sub_ranking">
    <table id="tbl_ranking">
        <colgroup>
            <col width="350"/>
            <col width="350"/>
        </colgroup>
        <thead>
        <tr>
            <th class="lbg"></th>
            <th class="rbg">Số thẻ tối đa nạp trong ngày</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Reset < <?php //echo $reset_1 ?> lần</td>
            <td><?php //echo $slg_card_1 ?> thẻ / ngày</td>
        </tr>
        <tr>
            <td><?php //echo $reset_1 ?> < Reset < <?php //echo $reset_2 ?> lần</td>
            <td><?php //echo $slg_card_2 ?> thẻ / ngày</td>
        </tr>
        <tr>
            <td><?php //echo $reset_2 ?> < Reset < <?php //echo $reset_3 ?> lần</td>
            <td><?php //echo $slg_card_3 ?> thẻ / ngày</td>
        </tr>
        <tr>
            <td><?php //echo $reset_3 ?> < Reset < <?php //echo $reset_4 ?> lần</td>
            <td><?php //echo $slg_card_4 ?> thẻ / ngày</td>
        </tr>
        <tr>
            <td><?php //echo $reset_4 ?> < Reset hoặc đã ReLife</td>
            <td><?php //echo $slg_card_max ?> thẻ / ngày</td>
        </tr>
        </tbody>
    </table>
</div>
</div>
