<?php

list($acc, $result, $notice, $char, $class, $class_current) = _GL('acc, result, notice, char, class, class_current');
?>

<div class="table-responsive">
    <table class="table" width="100%">
        <tr>
            <td><?= __('account') ?>:</td>
            <td>
                <form method="post" action="<?php echo REQUEST_URI; ?>">
                    <input type="text" name="acc" id="acc" maxlength="10" size="20" value="<?php echo $acc; ?>">
                    <input type="hidden" name="action" id="action" value="search_acc">
                    <input type="submit" name="Submit" value="Check">
                </form>
            </td>
            <td><?= __('block') ?>:</td>
            <td>
                <form method="post" action="">
                    <input type="text" name="acc" id="acc" maxlength="10" size="20" value="<?php echo $acc; ?>">
                    <input type="hidden" name="action" id="action" value="block_acc">
                    <input type="submit" name="Submit" value="Block">
                </form>
            </td>
            <td><?= __('unblock') ?>:</td>
            <td>
                <form method="post" action="">
                    <input type="text" name="acc" id="acc" maxlength="10" size="20" value="<?php echo $acc; ?>">
                    <input type="hidden" name="action" id="action" value="unblock_acc">
                    <input type="submit" name="Submit" value="Unblock">
                </form>
            </td>
        </tr>
    </table>

    <table class="table" width="100%">
        <form name="bank_add" method="post" action="<?php echo REQUEST_URI; ?>">
            <input type="hidden" name="action" id="action" value="bank_add">
            <tr>
                <td><?= __('account') ?>:</td>
                <td>
                    <input type="text" name="acc" id="acc" maxlength="10" size="20" value="<?php echo $acc; ?>">
                </td>
                <td>+ Zen Bank:</td>
                <td>
                    <input type="text" name="zen" id="zen" maxlength="10" size="20"
                           value="<?= isset($result['search_acc']['data']['bank']) ? $result['search_acc']['data']['bank'] : 0 ?>">
                </td>
                <td>+ V.Point:</td>
                <td>
                    <input type="text" name="vpoint" id="vpoint" maxlength="10" size="20"
                           value="<?= isset($result['search_acc']['data']['vpoint']) ? $result['search_acc']['data']['vpoint'] : 0 ?>">
                </td>
                <td>
                    <input type="submit" name="Submit" value="Add Bank">
                </td>
            </tr>
        </form>
    </table>

    <table class="table" width="100%">
        <form name="bank_sub" method="post" action="<?php echo REQUEST_URI; ?>">
            <input type="hidden" name="action" id="action" value="bank_sub">
            <tr>
                <td><?= __('account') ?></td>
                <td>
                    <input type="text" name="acc" id="acc" maxlength="10" size="20" value="<?php echo $acc; ?>">
                </td>
                <td>- Zen Bank:</td>
                <td>
                    <input type="text" name="zen" id="zen" maxlength="10" size="20"
                           value="<?= isset($result['search_acc']['data']['bank']) ? $result['search_acc']['data']['bank'] : 0 ?>">
                </td>
                <td>- V.Point:</td>
                <td>
                    <input type="text" name="vpoint" id="vpoint" maxlength="10" size="20"
                           value="<?= isset($result['search_acc']['data']['vpoint']) ? $result['search_acc']['data']['vpoint'] : 0 ?>">
                </td>
                <td><input type="submit" name="Submit" value="Sub Bank"></td>
            </tr>
        </form>
    </table>

    <table class="table" width="100%">
        <form name="bank_jewel" method="post" action="<?php echo REQUEST_URI; ?>">
            <input type="hidden" name="action" id="action" value="bank_jewel">
            <tr>
                <td><?= __('account') ?></td>
                <td><input type="text" name="acc" id="acc" maxlength="10" size="10" value="<?php echo $acc; ?>">
                </td>
                <td>Ngọc Hỗn Nguyên:</td>
                <td>
                    <input type="text" name="chao" id="chao" maxlength="10" size="10"
                           value="<?= isset($result['search_acc']['data']['jewel_chao']) ? $result['search_acc']['data']['jewel_chao'] : 0 ?>">
                </td>
                <td>Ngọc Sáng Tạo:</td>
                <td>
                    <input type="text" name="cre" id="cre" maxlength="10" size="10"
                           value="<?= isset($result['search_acc']['data']['jewel_cre']) ? $result['search_acc']['data']['jewel_cre'] : 0 ?>">
                </td>
                <td>Lông Vũ:</td>
                <td>
                    <input type="text" name="blue" id="blue" maxlength="10" size="10"
                           value="<?= isset($result['search_acc']['data']['jewel_blue']) ? $result['search_acc']['data']['jewel_blue'] : 0 ?>">
                </td>
                <td>
                    <input type="submit" name="Submit" value="Jewel">
                </td>
            </tr>
        </form>
    </table>

    <table class="table" width="85%" align="center">
        <form name="edit_acc" method="post" action="<?php echo REQUEST_URI; ?>">
            <input type="hidden" name="action" id="action" value="edit_acc">
            <tr>
                <td><?= __('account') ?>:</td>
                <td>
                    <input type="text" name="acc" id="acc" maxlength="10" size="20" value="<?php echo $acc; ?>">
                </td>
                <td>Email:</td>
                <td>
                    <input type="text" name="email" id="email" size="35"
                           value="<?= isset($result['search_acc']['data']['mail_addr']) ? $result['search_acc']['data']['mail_addr'] : "" ?>">
                </td>
                <td>Mật khẩu:</td>
                <td>
                    <input type="text" name="pass" id="pass" size="20"
                           value="<?= isset($result['search_acc']['data']['memb__pwd']) ? $result['search_acc']['data']['memb__pwd'] : "" ?>">
                </td>
                <td>
                    <input type="submit" name="Submit" value="Edit">
                </td>
            </tr>
        </form>
    </table>
    <br>

    <?php if (isset($notice) && $notice) { ?>
        <div id="notice" style="padding-left:20%;">
            <fieldset style="width:550px; padding:5px; border:1px solid #000000;"><?php echo $notice; ?></fieldset>
        </div>
        <br>
    <?php } ?>

    <br>

    <table class="table" width="100%">
        <tr>
            <td>Nhân vật:</td>
            <td>
                <form method="post" action="<?php echo REQUEST_URI; ?>">
                    <input type="text" name="char" id="char" maxlength="10" size="20" value="<?= $char; ?>">
                    <input type="hidden" name="action" id="action" value="search_char">
                    <input type="submit" name="Submit" value="Check">
                </form>
            </td>
            <td>Khóa:</td>
            <td>
                <form method="post" action="">
                    <input type="text" name="char" id="char" maxlength="10" size="20" value="<?= $char; ?>">
                    <input type="hidden" name="action" id="action" value="block_char">
                    <input type="submit" name="Submit" value="block">
                </form>
            </td>
            <td>Bỏ Khóa:</td>
            <td>
                <form method="post" action="">
                    <input type="text" name="char" id="char" maxlength="10" size="20" value="<?= $char; ?>">
                    <input type="hidden" name="action" id="action" value="unblock_char">
                    <input type="submit" name="Submit" value="unblock">
                </form>
            </td>
        </tr>
    </table>

    <form method="post" action="<?php echo REQUEST_URI; ?>">
        <input type="hidden" name="action" id="action" value="edit_char">
        <table class="table" width="50%" align="center">
            <tr>
                <td>Tên Nhân vật :
                    <input type="text" name="char" id="char" maxlength="10" size="10" value="<?= $char; ?>">
                </td>
                <td>Cấp độ :
                    <input type="text" name="level" id="level" maxlength="5" size="10"
                           value="<?= isset($result['search_char']['data']['cLevel']) ? $result['search_char']['data']['cLevel'] : "" ?>"></font>
                </td>
                <td>Chủng tộc :
                    <select id="class" name="class">
                        <option value="" selected="selected"> -- Chủng tộc --</option>
                        <option value="<?= $class['class_dw_1'] ?>"
                                <?php if ($class_current == $class['class_dw_1']) { ?>selected="selected"<?php } ?>><?= $class['class_dw_1_name'] ?></option>
                        <option value="<?= $class['class_dw_2'] ?>"
                                <?php if ($class_current == $class['class_dw_2']) { ?>selected="selected"<?php } ?>><?= $class['class_dw_2_name'] ?></option>
                        <option value="<?= $class['class_dw_3'] ?>"
                                <?php if ($class_current == $class['class_dw_3']) { ?>selected="selected"<?php } ?>><?= $class['class_dw_3_name'] ?></option>
                        <option value="<?= $class['class_dk_1'] ?>"
                                <?php if ($class_current == $class['class_dk_1']) { ?>selected="selected"<?php } ?>><?= $class['class_dk_1_name'] ?></option>
                        <option value="<?= $class['class_dk_2'] ?>"
                                <?php if ($class_current == $class['class_dk_2']) { ?>selected="selected"<?php } ?>><?= $class['class_dk_2_name'] ?></option>
                        <option value="<?= $class['class_dk_3'] ?>"
                                <?php if ($class_current == $class['class_dk_3']) { ?>selected="selected"<?php } ?>><?= $class['class_dk_3_name'] ?></option>
                        <option value="<?= $class['class_elf_1'] ?>"
                                <?php if ($class_current == $class['class_elf_1']) { ?>selected="selected"<?php } ?>><?= $class['class_elf_1_name'] ?></option>
                        <option value="<?= $class['class_elf_2'] ?>"
                                <?php if ($class_current == $class['class_elf_2']) { ?>selected="selected"<?php } ?>><?= $class['class_elf_2_name'] ?></option>
                        <option value="<?= $class['class_elf_3'] ?>"
                                <?php if ($class_current == $class['class_elf_3']) { ?>selected="selected"<?php } ?>><?= $class['class_elf_3_name'] ?></option>
                        <option value="<?= $class['class_mg_1'] ?>"
                                <?php if ($class_current == $class['class_mg_1']) { ?>selected="selected"<?php } ?>><?= $class['class_elf_3_name'] ?></option>
                        <option value="<?= $class['class_mg_2'] ?>"
                                <?php if ($class_current == $class['class_mg_2']) { ?>selected="selected"<?php } ?>><?= $class['class_elf_3_name'] ?></option>
                        <option value="<?= $class['class_dl_1'] ?>"
                                <?php if ($class == $class['class_dl_1']) { ?>selected="selected"<?php } ?>><?= $class['class_dl_1_name'] ?></option>
                        <option value="<?= $class['class_dl_2'] ?>"
                                <?php if ($class_current == $class['class_dl_2']) { ?>selected="selected"<?php } ?>><?= $class['class_dl_2_name'] ?></option>
                        <option value="<?= $class['class_sum_1'] ?>"
                                <?php if ($class_current == $class['class_sum_1']) { ?>selected="selected"<?php } ?>><?= $class['class_sum_1_name'] ?></option>
                        <option value="<?= $class['class_sum_2'] ?>"
                                <?php if ($class_current == $class['class_sum_2']) { ?>selected="selected"<?php } ?>><?= $class['class_sum_2_name'] ?></option>
                        <option value="<?= $class['class_sum_3'] ?>"
                                <?php if ($class_current == $class['class_sum_3']) { ?>selected="selected"<?php } ?>><?= $class['class_sum_3_name'] ?></option>
                        <option value="<?= $class['class_rf_1'] ?>"
                                <?php if ($class_current == $class['class_rf_1']) { ?>selected="selected"<?php } ?>><?= $class['class_rf_1_name'] ?></option>
                        <option value="<?= $class['class_rf_2'] ?>"
                                <?php if ($class_current == $class['class_rf_2']) { ?>selected="selected"<?php } ?>><?= $class['class_rf_2_name'] ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Sức mạnh :
                    <input type="text" name="str" id="str" maxlength="5" size="10"
                           value="<?= isset($result['search_char']['data']['Strength']) ? $result['search_char']['data']['Strength'] : "" ?>">
                </td>
                <td>Điểm chưa cộng :
                    <input type="point" name="point" id="char" maxlength="5" size="10"
                           value="<?= isset($result['search_char']['data']['LevelUpPoint']) ? $result['search_char']['data']['LevelUpPoint'] : "" ?>">
                </td>
                <td>Nhanh nhẹn : <input type="text" name="dex" id="dex" maxlength="5" size="10"
                                        value="<?php echo @$dex; ?>">
                </td>
            </tr>
            <tr>
                <td>Điểm dự trữ : <input type="text" name="pointdutru" id="pointdutru" maxlength="5" size="10"
                                         value="<?= isset($result['search_char']['data']['pointdutru']) ? $result['search_char']['data']['pointdutru'] : "" ?>">
                </td>
                <td>Sinh lực : <input type="text" name="vit" id="vit" maxlength="5" size="10"
                                      value="<?= isset($result['search_char']['data']['Vitality']) ? $result['search_char']['data']['Vitality'] : "" ?>">
                </td>
                <td>Năng lượng : <input type="text" name="ene" id="ene" maxlength="5" size="10"
                                        value="<?= isset($result['search_char']['data']['Energy']) ? $result['search_char']['data']['Energy'] : "" ?>">
                </td>
            </tr>
            <tr>
                <td>Reset : <input type="text" name="reset" id="reset" maxlength="5" size="10"
                                   value="<?= isset($result['search_char']['data']['Resets']) ? $result['search_char']['data']['Resets'] : "" ?>">
                </td>
                <td>Mệnh lệnh : <input type="text" name="com" id="com" maxlength="5" size="10"
                                       value="<?= isset($result['search_char']['data']['Leadership']) ? $result['search_char']['data']['Leadership'] : "" ?>">
                </td>
                <td>Relife : <input type="text" name="relife" id="relife" maxlength="5" size="10"
                                    value="<?= isset($result['search_char']['data']['Relifes']) ? $result['search_char']['data']['Relifes'] : "" ?>">
                </td>
            </tr>
        </table>
        <center><input type="submit" name="Submit" value="Submit"></center>
    </form>

    <hr>
    <form name="ketqua_xoso" method="post" action="">
        <input type="hidden" name="action" id="action" value="ketqua_xoso">
        <table align="center" cellpadding="2" cellspacing="5"
               style="border-color:#d1a151;border-width:2px;border-style:solid;width:55%;border-collapse:collapse;font-size:14px;font-weight:bold;">
            <tr>
                <td width="15%" align="center"
                    style="border-color:#d1a151;border-width:2px;border-style:solid;"><?php echo @$giaithuong1; ?> lần
                </td>
                <td width="85%" align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;"><input
                        name="result_info_0" type="text" maxlength="2" size="2"
                        value="<?php echo $_POST['result_info_0']; ?>"></td>
            </tr>
            <tr>
                <td align="center"
                    style="border-color:#d1a151;border-width:2px;border-style:solid;"><?php echo @$giaithuong2; ?> lần
                </td>
                <td align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;"><input
                        name="result_info_1" type="text" maxlength="3" size="3"
                        value="<?php echo $_POST['result_info_1']; ?>"></td>
            </tr>
            <tr>
                <td align="center"
                    style="border-color:#d1a151;border-width:2px;border-style:solid;"><?php echo @$giaithuong3; ?> lần
                </td>
                <td align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;"><input
                        name="result_info_2" type="text" maxlength="4" size="4"
                        value="<?php echo $_POST['result_info_2']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                        name="result_info_3" type="text" maxlength="4" size="4"
                        value="<?php echo $_POST['result_info_3']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                        name="result_info_4" type="text" maxlength="4" size="4"
                        value="<?php echo $_POST['result_info_4']; ?>"></td>
            </tr>
            <tr>
                <td align="center"
                    style="border-color:#d1a151;border-width:2px;border-style:solid;"><?php echo @$giaithuong4; ?> lần
                </td>
                <td align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;"><input
                        name="result_info_5" type="text" maxlength="4" size="4"
                        value="<?php echo $_POST['result_info_5']; ?>"></td>
            </tr>
            <tr>
                <td align="center"
                    style="border-color:#d1a151;border-width:2px;border-style:solid;"><?php echo @$giaithuong5; ?> lần
                </td>
                <td align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;">
                    <input name="result_info_6" type="text" maxlength="5" size="5"
                           value="<?php echo @$_POST['result_info_6']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="result_info_7" type="text" maxlength="5" size="5"
                           value="<?php echo @$_POST['result_info_7']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="result_info_8" type="text" maxlength="5" size="5"
                           value="<?php echo @$_POST['result_info_8']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="result_info_9" type="text" maxlength="5" size="5"
                           value="<?php echo @$_POST['result_info_9']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="result_info_10" type="text" maxlength="5" size="5"
                           value="<?php echo @$_POST['result_info_10']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="result_info_11" type="text" maxlength="5" size="5"
                           value="<?php echo $_POST['result_info_11']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="result_info_12" type="text" maxlength="5" size="5"
                           value="<?php echo @$_POST['result_info_12']; ?>"></td>
            </tr>
            <tr>
                <td align="center"
                    style="border-color:#d1a151;border-width:2px;border-style:solid;"><?php echo @$giaithuong6; ?> lần
                </td>
                <td align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;"><input
                        name="result_info_13" type="text" maxlength="5" size="5"
                        value="<?php echo $_POST['result_info_13']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                        name="result_info_14" type="text" maxlength="5" size="5"
                        value="<?php echo $_POST['result_info_14']; ?>"></td>
            </tr>
            <tr>
                <td align="center"
                    style="border-color:#d1a151;border-width:2px;border-style:solid;"><?php echo @$giaithuong7; ?> lần
                </td>
                <td align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;"><input
                        name="result_info_15" type="text" maxlength="5" size="5"
                        value="<?php echo $_POST['result_info_15']; ?>"></td>
            </tr>
            <tr>
                <td align="center"
                    style="border-color:#d1a151;border-width:2px;border-style:solid;"><?php echo @$giaithuong8; ?> lần
                </td>
                <td align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;"><input
                        name="result_info_16" type="text" maxlength="5" size="5"
                        value="<?php echo $_POST['result_info_16']; ?>"></td>
            </tr>
            <tr>
                <td align="center"
                    style="border-color:#d1a151;border-width:2px;border-style:solid;"><?php echo @$giaithuong9; ?> lần
                </td>
                <td align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;"><input
                        name="result_info_17" type="text" maxlength="6" size="6"
                        value="<?php echo @$_POST['result_info_17']; ?>"></td>
            </tr>
        </table>
        <center><input type="submit" name="Submit" value="Submit"></center>
    </form>

</div>
