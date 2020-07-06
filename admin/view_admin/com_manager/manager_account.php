<?php

list($acc, $result, $notice, $char, $class, $class_current) = _GL('acc, result, notice, char, class, class_current');

cn_snippet_messages();
?>

<div class="table-responsive">
    <div class="row">
        <div class="col-sm-4">
            <div class="col-sm-4">
                <?= __('account') ?>
            </div>
            <div class="col-sm-8">
                <form method="post" action="<?php echo REQUEST_URI; ?>">
                    <input type="text" name="acc" id="acc" maxlength="10" size="20" value="<?php echo $acc; ?>">
                    <input type="hidden" name="action" id="action" value="search_acc">
                    <input type="submit" name="Submit" value="Check">
                </form>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="col-sm-4"><?= __('block') ?></div>
            <div class="col-sm-8">
                <form method="post" action="<?php echo REQUEST_URI; ?>">
                    <input required="required" type="text" name="acc" id="acc" maxlength="10" size="20" value="<?php echo $acc; ?>">
                    <input type="hidden" name="action" id="action" value="block_acc">
                    <input type="submit" name="Submit" value="Block">
                </form>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="col-sm-4"><?= __('unblock') ?></div>
            <div class="col-sm-8">
                <form method="post" action="<?php echo REQUEST_URI; ?>">
                    <input required="required" type="text" name="acc" id="acc" maxlength="10" size="20" value="<?php echo $acc; ?>">
                    <input type="hidden" name="action" id="action" value="unblock_acc">
                    <input type="submit" name="Submit" value="Unblock">
                </form>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <form name="bank_add" method="post" action="<?php echo REQUEST_URI; ?>">
            <input type="hidden" name="action" id="action" value="bank_add">
            <div class="col-sm-4">
                <div class="col-sm-4"><?= __('account') ?></div>
                <div class="col-sm-8">
                    <input type="text" name="acc" id="acc" maxlength="10" size="20" value="<?php echo $acc; ?>">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="col-sm-4">+ Zen Bank</div>
                <div class="col-sm-8">
                    <input type="text" name="zen" id="zen" maxlength="10" size="20"
                           value="<?= isset($result['search_acc']['data']['bank']) ? $result['search_acc']['data']['bank'] : 0 ?>">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="col-sm-4">+ V.Point</div>
                <div class="col-sm-8">
                    <input type="text" name="vpoint" id="vpoint" maxlength="10" size="20"
                           value="<?= isset($result['search_acc']['data']['vpoint']) ? $result['search_acc']['data']['vpoint'] : 0 ?>">
                    <input type="submit" name="Submit" value="Add Bank">
                </div>
            </div>
        </form>
    </div>
    <hr>

    <div class="row">
        <form name="bank_sub" method="post" action="<?php echo REQUEST_URI; ?>">
            <input type="hidden" name="action" id="action" value="bank_sub">
            <div class="col-sm-4">
                <div class="col-sm-4"><?= __('account') ?></div>
                <div class="col-sm-8"><input type="text" name="acc" id="acc" maxlength="10" size="20"
                                             value="<?php echo $acc; ?>"></div>
            </div>
            <div class="col-sm-4">
                <div class="col-sm-4">- Zen Bank</div>
                <div class="col-sm-8">
                    <input type="text" name="zen" id="zen" maxlength="10" size="20"
                           value="<?= isset($result['search_acc']['data']['bank']) ? $result['search_acc']['data']['bank'] : 0 ?>">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="col-sm-4">V.Point</div>
                <div class="col-sm-8">
                    <input type="text" name="vpoint" id="vpoint" maxlength="10" size="20"
                           value="<?= isset($result['search_acc']['data']['vpoint']) ? $result['search_acc']['data']['vpoint'] : 0 ?>">
                    <input type="submit" name="Submit" value="Sub Bank">
                </div>
            </div>
        </form>
    </div>
    <hr>
    <div class="row">
        <form name="edit_acc" method="post" action="<?php echo REQUEST_URI; ?>">
            <input type="hidden" name="action" id="action" value="edit_acc">
            <div class="col-sm-4">
                <div class="col-sm-4"><?= __('account') ?></div>
                <div class="col-sm-8">
                    <input type="text" name="acc" id="acc" maxlength="10" size="20" value="<?php echo $acc; ?>">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="col-sm-4">Email</div>
                <div class="col-sm-8">
                    <input type="text" name="email" id="email" size="20"
                           value="<?= isset($result['search_acc']['data']['mail_addr']) ? $result['search_acc']['data']['mail_addr'] : "" ?>">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="col-sm-4">Mật khẩu</div>
                <div class="col-sm-8">
                    <input type="text" name="pass" id="pass" size="20"
                           value="<?= isset($result['search_acc']['data']['memb__pwd']) ? $result['search_acc']['data']['memb__pwd'] : "" ?>">
                    <input type="submit" name="Submit" value="Edit">
                </div>
            </div>
        </form>
    </div>

    <hr>
    <div class="row">
        <form name="bank_jewel" method="post" action="<?php echo REQUEST_URI; ?>">
            <input type="hidden" name="action" id="action" value="bank_jewel">
            <div class="col-sm-6 logs-mb-3">
                <div class="col-sm-4"><?= __('account') ?></div>
                <div class="col-sm-8">
                    <input type="text" name="acc" id="acc" maxlength="10" size="20" value="<?php echo $acc; ?>">
                </div>
            </div>
            <div class="col-sm-6 logs-mb-3">
                <div class="col-sm-4">Ngọc Hỗn Nguyên</div>
                <div class="col-sm-8">
                    <input type="text" name="chao" id="chao" maxlength="10" size="20"
                           value="<?= isset($result['search_acc']['data']['jewel_chao']) ? $result['search_acc']['data']['jewel_chao'] : 0 ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="col-sm-4">Ngọc Sáng Tạo</div>
                <div class="col-sm-8">
                    <input type="text" name="cre" id="cre" maxlength="10" size="20"
                           value="<?= isset($result['search_acc']['data']['jewel_cre']) ? $result['search_acc']['data']['jewel_cre'] : 0 ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="col-sm-4">Lông Vũ</div>
                <div class="col-sm-8">
                    <input type="text" name="blue" id="blue" maxlength="10" size="20"
                           value="<?= isset($result['search_acc']['data']['jewel_blue']) ? $result['search_acc']['data']['jewel_blue'] : 0 ?>">
                    <input type="submit" name="Submit" value="Jewel">
                </div>
            </div>
        </form>
    </div>

    <br>

    <?php if (isset($notice) && $notice) { ?>
        <div id="notice" style="padding-left:20%;">
            <fieldset style="width:550px; padding:5px; border:1px solid #000000;"><?php echo $notice; ?></fieldset>
        </div>
        <br>
    <?php } ?>

    <br>

    <div class="row">
        <div class="col-sm-4">
            <div class="col-sm-4">Nhân vật</div>
            <div class="col-sm-8">
                <form method="post" action="<?php echo REQUEST_URI; ?>">
                    <input type="text" name="char" id="char" maxlength="10" size="20" value="<?= $char; ?>">
                    <input type="hidden" name="action" id="action" value="search_char">
                    <input type="submit" name="Submit" value="Check">
                </form>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="col-sm-4">Khóa</div>
            <div class="col-sm-8">
                <form method="post" action="">
                    <input type="text" name="char" id="char" maxlength="10" size="20" value="<?= $char; ?>">
                    <input type="hidden" name="action" id="action" value="block_char">
                    <input type="submit" name="Submit" value="block">
                </form>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="col-sm-4">Bỏ Khóa</div>
            <div class="col-sm-8">
                <form method="post" action="">
                    <input type="text" name="char" id="char" maxlength="10" size="20" value="<?= $char; ?>">
                    <input type="hidden" name="action" id="action" value="unblock_char">
                    <input type="submit" name="Submit" value="unblock">
                </form>
            </div>
        </div>
        <hr>
        <form method="post" action="<?php echo REQUEST_URI; ?>">
            <input type="hidden" name="action" id="action" value="edit_char">
            <div class="col-sm-4 logs-mb-3">
                <div class="col-sm-4">Tên Nhân vật</div>
                <div class="col-sm-8">
                    <input type="text" name="char" id="char" maxlength="10" size="20" value="<?= $char; ?>">
                </div>
            </div>
            <div class="col-sm-4 logs-mb-3">
                <div class="col-sm-4">Cấp độ</div>
                <div class="col-sm-8">
                    <input type="text" name="level" id="level" maxlength="5" size="20"
                           value="<?= isset($result['search_char']['data']['cLevel']) ? $result['search_char']['data']['cLevel'] : "" ?>">
                </div>
            </div>
            <div class="col-sm-4 logs-mb-3">
                <div class="col-sm-4">Chủng tộc</div>
                <div class="col-sm-8">
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
                </div>
            </div>
            <div style="clear: both"></div>
            <div class="col-sm-4 logs-mb-3">
                <div class="col-sm-4">Sức mạnh</div>
                <div class="col-sm-8">
                    <input type="text" name="str" id="str" maxlength="5" size="20"
                           value="<?= isset($result['search_char']['data']['Strength']) ? $result['search_char']['data']['Strength'] : "" ?>">
                </div>
            </div>
            <div class="col-sm-4 logs-mb-3">
                <div class="col-sm-4">Điểm chưa cộng</div>
                <div class="col-sm-8">
                    <input type="point" name="point" id="char" maxlength="5" size="20"
                           value="<?= isset($result['search_char']['data']['LevelUpPoint']) ? $result['search_char']['data']['LevelUpPoint'] : "" ?>">
                </div>
            </div>
            <div class="col-sm-4 logs-mb-3">
                <div class="col-sm-4">Nhanh nhẹn</div>
                <div class="col-sm-8">
                    <input type="text" name="dex" id="dex" maxlength="5" size="20"
                           value="<?= isset($result['search_char']['data']['Dexterity']) ? $result['search_char']['data']['Dexterity'] : "" ?>">
                </div>
            </div>
            <div style="clear: both"></div>
            <div class="col-sm-4 logs-mb-3">
                <div class="col-sm-4">Điểm dự trữ</div>
                <div class="col-sm-8">
                    <input type="text" name="pointdutru" id="pointdutru" maxlength="5" size="20"
                           value="<?= isset($result['search_char']['data']['pointdutru']) ? $result['search_char']['data']['pointdutru'] : "" ?>">
                </div>
            </div>
            <div class="col-sm-4 logs-mb-3">
                <div class="col-sm-4">Sinh lực</div>
                <div class="col-sm-8">
                    <input type="text" name="vit" id="vit" maxlength="5" size="20"
                           value="<?= isset($result['search_char']['data']['Vitality']) ? $result['search_char']['data']['Vitality'] : "" ?>">
                </div>
            </div>
            <div class="col-sm-4 logs-mb-3">
                <div class="col-sm-4">Năng lượng</div>
                <div class="col-sm-8">
                    <input type="text" name="ene" id="ene" maxlength="5" size="20"
                           value="<?= isset($result['search_char']['data']['Energy']) ? $result['search_char']['data']['Energy'] : "" ?>">
                </div>
            </div>
            <div style="clear: both"></div>
            <div class="col-sm-4 logs-mb-3">
                <div class="col-sm-4">Reset</div>
                <div class="col-sm-8">
                    <input type="text" name="reset" id="reset" maxlength="5" size="20"
                           value="<?= isset($result['search_char']['data']['Resets']) ? $result['search_char']['data']['Resets'] : "" ?>">
                </div>
            </div>
            <div class="col-sm-4 logs-mb-3">
                <div class="col-sm-4">Mệnh lệnh</div>
                <div class="col-sm-8">
                    <input type="text" name="com" id="com" maxlength="5" size="20"
                           value="<?= isset($result['search_char']['data']['Leadership']) ? $result['search_char']['data']['Leadership'] : "" ?>">
                </div>
            </div>
            <div class="col-sm-4 logs-mb-3">
                <div class="col-sm-4">Relife</div>
                <div class="col-sm-8">
                    <input type="text" name="relife" id="relife" maxlength="5" size="20"
                           value="<?= isset($result['search_char']['data']['Relifes']) ? $result['search_char']['data']['Relifes'] : "" ?>">
                </div>
            </div>
            <div class="col-sm-12 logs-mb-3 logs-mt-3" align="center">
                <div class="col-4">
                    <input type="submit" name="Submit" value="Submit">
                </div>
            </div>
        </form>

    </div>
</div>
