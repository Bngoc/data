<?php
$odd = 0;
$i = 0;
$ok_loop = false;
$ok_loop2 = false;
list($gh_loai1, $gh_loai2, $all_templates, $template_text, $template, $sub, $can_delete, $all_header_conf, $set_arr) = _GL('gh_loai1, gh_loai2, all_templates, template_text, template, sub, can_delete, all_header_conf, set_arr');

cn_snippet_messages();
cn_snippet_bc();

?>


<ul class="sysconf_top">
    <?php foreach ($all_header_conf as $ID => $ol) { ?>
        <li<?php if ($sub == $ID) echo ' class="selected"'; ?>><a
                href="<?php echo cn_url_modify('mod=editconfig', 'opt=ischaracter', "sub=$ID"); ?>"><?php echo ucfirst($ol['name']); ?></a>
        </li>
    <?php } ?>
</ul>
<div style="clear: both;"></div>

<form action="<?php echo PHP_SELF; ?>" method="POST">

    <?php cn_form_open('mod, opt, sub'); ?>

    <table class="std-table opt_table">
        <?php if ($sub === 'class') { ?>
            <tr>
                <th>Option name</th>
                <th>Configuration parameter</th>
                <th>Option name</th>
                <th>Configuration parameter</th>
            </tr>
            <?php foreach ($set_arr as $df => $fd) { ?>
                <tr <?php if ($odd++ % 2) echo ' style="background: #f8f8f8;"'; ?>>
                    <td><?php echo $fd['title']; ?></td>
                    <td align="center"><input type="number" name="config[<?php echo $fd['id_1']; ?>]"
                                              value="<?php echo $fd['id_1_val']; ?>" style="width:65px" maxlength="2">
                    </td>
                    <td><?php echo $fd['desc']; ?></td>
                    <td align="center"><input type="word" name="config[<?php echo $fd['id_2']; ?>]"
                                              value="<?php echo $fd['id_2_val']; ?>" size="20" maxlength="19"></td>
                </tr>
                <?php if ($fd['end']) echo '<tr><td colspan="4"><hr></td></tr>';
            } ?>
            <tr>
                <td colspan="4" align="right"><input type="submit" style="font-weight:bold;font-size:120%;"
                                                     value="Save changes"/></td>
            </tr>

        <?php } else if ($sub === "reset") { ?>
            <!-- Số cấp Reset hiển thị dành cho người chơi : <input type="number" name="cap_reset_max" value="<?php //echo $cap_reset_max; ?>" size="2"/><br>
				Số cấp Reset nhỏ nhất để ghi Log (Reset lớn hơn sẽ được ghi vào Log) : <input type="number" name="log_reset" value="<?php //echo $log_reset; ?>" size="2"/><br><br>
				<i><b>Time</b>: Là khoảng thời gian được phép thực hiện lần Reset tiếp theo (tính theo phút)</i><br><br>-->
            <th align="center"><b>Cấp Reset</b></th>
            <th align="center"><b>Reset</b></th>
            <th align="center"><b>Level</b></th>
            <th align="center"><b>Zen</b></th>
            <th align="center"><b>Chao</b></th>
            <th align="center"><b>Create</b></th>
            <th align="center"><b>Blue</b></th>
            <th align="center"><b>Point</b></th>
            <th align="center"><b>Mệnh lệnh</b></th>
            <th align="center"><b>Time</b></th>

            <?php if ($set_arr) foreach ($set_arr as $df => $fd) {
                if ($ok_loop) {
                    $lv_rs_f = $lv_rs_e;
                    $lv_rs_e = $fd['id_1_val'];
                } else {
                    $lv_rs_f = 0;
                    $lv_rs_e = $fd['id_1_val'];
                    $ok_loop = true;
                } ?>
                <tr <?php if ($odd++ % 2) echo 'style="background: #f8f8f8;"'; ?>>
                    <td align="center"><b>Cấp <?php echo ++$i; ?></b></td>
                    <td align="center"> <?php echo ++$lv_rs_f; ?> &rarr; <input type="number"
                                                                                name="config[<?php echo $fd['id_1']; ?>]"
                                                                                value="<?php echo $fd['id_1_val']; ?>"
                                                                                style="width:65px"/></td>
                    <td align="center"><input type="number" name="config[<?php echo $fd['id_2']; ?>]"
                                              value="<?php echo $fd['id_2_val']; ?>" style="width:65px"/></td>
                    <td align="center"><input type="number" name="config[<?php echo $fd['id_3']; ?>]"
                                              value="<?php echo $fd['id_3_val']; ?>"
                                              style="width:165px"/></td>
                    <td align="center"><input type="number" name="config[<?php echo $fd['id_4']; ?>]"
                                              value="<?php echo $fd['id_4_val']; ?>" style="width:65px"/></td>
                    <td align="center"><input type="number" name="config[<?php echo $fd['id_5']; ?>]"
                                              value="<?php echo $fd['id_5_val']; ?>" style="width:65px"/></td>
                    <td align="center"><input type="number" name="config[<?php echo $fd['id_6']; ?>]"
                                              value="<?php echo $fd['id_6_val']; ?>" style="width:65px"/></td>
                    <td align="center"><input type="number" name="config[<?php echo $fd['id_7']; ?>]"
                                              value="<?php echo $fd['id_7_val']; ?>" style="width:65px"/></td>
                    <td align="center"><input type="number" name="config[<?php echo $fd['id_8']; ?>]"
                                              value="<?php echo $fd['id_8_val']; ?>" style="width:65px"/></td>
                    <td align="center"><input type="number" name="config[<?php echo $fd['id_9']; ?>]"
                                              value="<?php echo $fd['id_9_val']; ?>" style="width:65px"/></td>
                </tr>
                <?php if ($fd['end']) echo '<tr><td colspan="10"><hr></td></tr>';
            } ?>
            <tr>
                <td colspan="10"><i><b>Time</b>: Là khoảng thời gian được phép thực hiện lần Reset tiếp theo (tính theo
                        phút)</i></td>
            </tr>
            <tr>
                <td colspan="10" align="right"><input type="submit" style="font-weight:bold;font-size:120%;"
                                                      value="Save changes"/></td>
            </tr>

        <?php } else if ($sub === "reset_vip") { ?>

            <th align="center"><b>Reset</b></th>
            <th align="center"><b>Level</b></th>
            <th align="center"><b>Vpoint</b></th>
            <th align="center"><b>Gcoin (Gcoin KM) = 80% Vp</b></th>
            <th align="center"><b>Point</b></th>
            <th align="center"><b>Mệnh Lệnh</b></th>

            <?php if ($set_arr) foreach ($set_arr as $df => $fd) {
                if ($ok_loop) {
                    $lv_rs_f = $lv_rs_e;
                    $lv_rs_e = $fd['id_1_val'];
                } else {
                    $lv_rs_f = 0;
                    $lv_rs_e = $fd['id_1_val'];
                    $ok_loop = true;
                } ?>
                <tr <?php if ($odd++ % 2) echo 'style="background: #f8f8f8;"'; ?>>
                    <td align="center"> <?php echo ++$lv_rs_f . ' &rarr; ' . $lv_rs_e; ?> </td>
                    <td align="center"><input type="number" name="config[<?php echo $fd['id_2']; ?>]"
                                              value="<?php echo $fd['id_2_val']; ?>" size="5"/></td>
                    <td align="center"><input type="number" name="config[<?php echo $fd['id_3']; ?>]"
                                              value="<?php echo $fd['id_3_val']; ?>" size="15"/></td>
                    <td align="center"><input readonly="readonly" name="config[<?php echo $fd['id_4']; ?>]"
                                              value="<?php echo (int)$fd['id_3_val'] * 0.8; ?>" size="15"/></td>
                    <td align="center"><input type="number" name="config[<?php echo $fd['id_5']; ?>]"
                                              value="<?php echo $fd['id_5_val']; ?>" size="15"/></td>
                    <td align="center"><input type="number" name="config[<?php echo $fd['id_6']; ?>]"
                                              value="<?php echo $fd['id_6_val']; ?>" size="5"/></td>
                </tr>
                <?php if ($fd['end']) echo '<tr><td colspan="6"><hr></td></tr>';
            } ?>

            <tr>
                <td colspan="6" align="right"><input type="submit" style="font-weight:bold;font-size:120%;"
                                                     value="Save changes"/></td>
            </tr>

        <?php } else if ($sub === "uythac_reset") { ?>

            <th align="center"><b>Reset</b></th>
            <th align="center"><b>Point ủy thác</b></th>
            <th align="center"><b>Zen</b></th>
            <th align="center"><b>Chaos</b></th>
            <th align="center"><b>Create</b></th>
            <th align="center"><b>Blue</b></th>

            <?php if ($set_arr) foreach ($set_arr as $df => $fd) {
                if ($ok_loop) {
                    $lv_rs_f = $lv_rs_e;
                    $lv_rs_e = $fd['id_1_val'];
                } else {
                    $lv_rs_f = 0;
                    $lv_rs_e = $fd['id_1_val'];
                    $ok_loop = true;
                } ?>
                <tr <?php if ($odd++ % 2) echo 'style="background: #f8f8f8;"'; ?>>
                    <td align="center"> <?php echo ++$lv_rs_f . ' &rarr; ' . $lv_rs_e; ?> </td>
                    <td align="center"><input type="number" name="config[<?php echo $fd['id_2']; ?>]"
                                              value="<?php echo $fd['id_2_val']; ?>" size="5"/></td>
                    <td align="center"><input readonly="readonly"
                                              value="<?php echo $fd['id_3_val']; ?>"
                                              size="15"/></td>
                    <td align="center"><input readonly="readonly" value="<?php echo $fd['id_4_val']; ?>" size="15"/>
                    </td>
                    <td align="center"><input readonly="readonly" value="<?php echo $fd['id_5_val']; ?>" size="15"/>
                    </td>
                    <td align="center"><input readonly="readonly" value="<?php echo $fd['id_6_val']; ?>" size="5"/></td>
                </tr>
                <?php if ($fd['end']) echo '<tr><td colspan="6"><hr></td></tr>';
            } ?>

            <tr>
                <td colspan="6" align="right"><input type="submit" style="font-weight:bold;font-size:120%;"
                                                     value="Save changes"/></td>
            </tr>

        <?php } else if ($sub === "uythac_resetvip") { ?>

            <th align="center"><b>Reset</b></th>
            <th align="center"><b>Point ủy thác</b></th>
            <th align="center"><b>Vpoint</b></th>
            <th align="center"><b>Gcoin (Gcoin KM) = 80% Vp</b></th>

            <?php if ($set_arr) foreach ($set_arr as $df => $fd) {
                if ($ok_loop) {
                    $lv_rs_f = $lv_rs_e;
                    $lv_rs_e = $fd['id_1_val'];
                } else {
                    $lv_rs_f = 0;
                    $lv_rs_e = $fd['id_1_val'];
                    $ok_loop = true;
                } ?>
                <tr <?php if ($odd++ % 2) echo 'style="background: #f8f8f8;"'; ?>>
                    <td align="center"> <?php echo ++$lv_rs_f . ' &rarr; ' . $lv_rs_e; ?> </td>
                    <td align="center"><input type="number" name="config[<?php echo $fd['id_2']; ?>]"
                                              value="<?php echo $fd['id_2_val']; ?>" size="5"/></td>
                    <td align="center"><input readonly="readonly"
                                              value="<?php echo $fd['id_3_val']; ?>"
                                              size="15"/></td>
                    <td align="center"><input readonly="readonly"
                                              value="<?php echo $fd['id_4_val']; ?>"
                                              size="15"/></td>
                </tr>
                <?php if ($fd['end']) echo '<tr><td colspan="4"><hr></td></tr>';
            } ?>

            <tr>
                <td colspan="6" align="right"><input type="submit" style="font-weight:bold;font-size:120%;"
                                                     value="Save changes"/></td>
            </tr>

        <?php } else if ($sub === "gioihan_rs") { ?>

            <th align="center"><b>Cấu hình Giới Hạn Reset Loại I</b></th>
            <th></th>
            <th align="center"><b>Cấu hình Giới Hạn Reset Loại II</b></th>
            <tr>
                <td>
                    <table class="std-table opt_table">
                        <tr bgcolor="#FFFFFF">
                            <td>
                                <div align="center"><b>TOP</b></div>
                            </td>
                            <td>
                                <div align="center"><b>Reset</b></div>
                            </td>
                        </tr>
                        <?php if ($gh_loai1) foreach ($gh_loai1 as $key => $val) {
                            if ($ok_loop) {
                                $i_f = $i_e;
                                $i_e = $i_e + 10;
                            } else {
                                $i_f = 0;
                                $i_e = 10;
                                $ok_loop = True;
                            } ?>
                            <tr <?php if ($odd++ % 2) echo 'style="background: #f8f8f8;"'; ?>>
                                <td align="center"><b>TOP <?php if (++$i_f > 50) {
                                            echo ' > ' . --$i_f;
                                        } else {
                                            echo $i_f . ' &rarr; ' . $i_e;
                                        } ?></b></td>
                                <td align="center">Reset tối đa <input type="text" name="config[<?php echo $key; ?>]"
                                                                       value="<?php echo $val['top_gh']; ?>" size="1"/>
                                    lần/ngày
                                </td>
                            </tr>

                        <?php } ?>
                    </table>
                </td>
                <td></td>
                <td>
                    <table class="std-table opt_table">
                        <?php if ($gh_loai2) foreach ($gh_loai2 as $key => $val) { ?>
                            <tr bgcolor="#FFFFFF">
                                <td>
                                    <div align="center"><b>Reset</b></div>
                                </td>
                                <td>
                                    <div align="center"><b>1 &rarr; <input type="number"
                                                                           name="config[<?php echo $val['id_day1']; ?>]"
                                                                           value="<?php echo $val['day1']; ?>"
                                                                           style="width:65px"> RS/ngày</b></div>
                                </td>
                                <td>
                                    <div align="center"><b><?php echo ++$val['day1']; ?> &rarr; <input type="number"
                                                                                                       name="config[<?php echo $val['id_day2']; ?>]"
                                                                                                       value="<?php echo $val['day2']; ?>"
                                                                                                       style="width:65px">
                                            RS/ngày</b></div>
                                </td>
                                <td>
                                    <div align="center"><b> >> <input readonly="readonly" name=""
                                                                      value="<?php echo $val['day2']; ?>"
                                                                      style="width:65px"> RS/ngày</b></div>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php if ($set_arr) foreach ($set_arr as $key => $val) {
                            if ($ok_loop2) {
                                $lv_rs_f = $lv_rs_en;
                                $lv_rs_en = $val['id_4_val'];
                            } else {
                                $lv_rs_f = 0;
                                $lv_rs_en = $val['id_4_val'];
                                $ok_loop2 = true;
                            } ?>
                            <tr <?php if ($odd++ % 2) echo 'style="background: #f8f8f8;"'; ?>>
                                <td>
                                    <div align="center"> <?php echo ++$lv_rs_f; ?> &rarr; <input type="number"
                                                                                                 name="config[<?php echo $val['id_4']; ?>]"
                                                                                                 value="<?php echo $val['id_4_val']; ?>"
                                                                                                 style="width:65px">
                                    </div>
                                </td>
                                <td>
                                    <div align="center"><input type="number" name="config[<?php echo $val['id_1']; ?>]"
                                                               value="<?php echo $val['id_1_val']; ?>"
                                                               style="width:65px"> Vpoint
                                    </div>
                                </td>
                                <td>
                                    <div align="center"><input type="number" name="config[<?php echo $val['id_2']; ?>]"
                                                               value="<?php echo $val['id_2_val']; ?>"
                                                               style="width:65px"> Vpoint
                                    </div>
                                </td>
                                <td>
                                    <div align="center"><input type="number" name="config[<?php echo $val['id_3']; ?>]"
                                                               value="<?php echo $val['id_3_val']; ?>"
                                                               style="width:65px"> Vpoint
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </td>
            </tr>
            <?php if ($val['end']) echo '<tr><td colspan="3"><hr></td></tr>'; ?>
            <tr>
                <td colspan="3" align="right"><input type="submit" style="font-weight:bold;font-size:120%;"
                                                     value="Save changes"/></td>
            </tr>

        <?php } else if ($sub === "hotro_tanthu") { ?>

            <th align="center"><b>Cấp</b></th>
            <th align="center"><b>Reset</b></th>
            <th align="center"><b>ReLife</b></th>
            <th align="center"><b>Level giảm</b></th>

            <?php if ($set_arr) foreach ($set_arr as $df => $fd) { ?>
                <tr <?php if ($odd++ % 2) echo 'style="background: #f8f8f8;"'; ?>>
                    <td align="center"><b>Cấp <?php echo ++$i; ?></b></td>
                    <td align="center"><input type="number" name="config[<?php echo $fd['id_1']; ?>]"
                                              value="<?php echo $fd['id_1_val']; ?>" style="width:65px"/>&le; Reset &le;<input
                            type="number" name="config[<?php echo $fd['id_2']; ?>]"
                            value="<?php echo $fd['id_2_val']; ?>" style="width:65px"/></td>
                    <td align="center"><input type="number" name="config[<?php echo $fd['id_3']; ?>]"
                                              value="<?php echo $fd['id_3_val']; ?>" style="width:65px"/>&le;
                        ReLife &le;<input type="number" name="config[<?php echo $fd['id_4']; ?>]"
                                          value="<?php echo $fd['id_4_val']; ?>" style="width:65px"/></td>
                    <td align="center"><input type="number" name="config[<?php echo $fd['id_5']; ?>]"
                                              value="<?php echo $fd['id_5_val']; ?>" style="width:65px"/></td>
                </tr>
                <?php if ($fd['end']) echo '<tr><td colspan="5"><hr></td></tr>';
            } ?>

            <tr>
                <td colspan="5" align="right"><input type="submit" style="font-weight:bold;font-size:120%;"
                                                     value="Save changes"/></td>
            </tr>

        <?php } else if ($sub === "relife") { ?>

            <th align="center"><b>ReLife</b></th>
            <th align="center"><b>Reset</b></th>
            <th align="center"><b>Level</b></th>
            <th align="center"><b> Point</b></th>
            <th align="center"><b>Mệnh Lệnh</b></th>

            <?php if ($set_arr) foreach ($set_arr as $df => $fd) {
                if ($ok_loop) {
                    $lv_rs_f = $lv_rs_e;
                    ++$lv_rs_e;
                } else {
                    $lv_rs_f = 0;
                    $lv_rs_e = 1;
                    $ok_loop = true;
                } ?>
                <tr <?php if ($odd++ % 2) echo 'style="background: #f8f8f8;"'; ?>>
                    <td align="center"> <?php echo ++$lv_rs_f; ?> </td>
                    <td align="center"><input type="number" name="config[<?php echo $fd['id_1']; ?>]"
                                              value="<?php echo $fd['id_1_val']; ?>" size="5"/></td>
                    <td align="center">400</td>
                    <td align="center"><input type="number" name="config[<?php echo $fd['id_2']; ?>]"
                                              value="<?php echo $fd['id_2_val']; ?>" size="15"/></td>
                    <td align="center"><input type="number" name="config[<?php echo $fd['id_3']; ?>]"
                                              value="<?php echo $fd['id_3_val']; ?>" size="5"/></td>
                </tr>
                <?php if ($fd['end']) echo '<tr><td colspan="5"><hr></td></tr>';
            } ?>

            <tr>
                <td colspan="5" align="right"><input type="submit" style="font-weight:bold;font-size:120%;"
                                                     value="Save changes"/></td>
            </tr>

        <?php } else if ($sub === "thue_point") { ?>

            <th align="center"><b>Số Point thuê</b></th>
            <th align="center"><b>Số V.Point cần khi thuê</b></th>
            <th align="center"><b>Cấp Relife yêu cầu khi thuê</b></th>

            <?php if ($set_arr) foreach ($set_arr as $df => $fd) { ?>
                <tr <?php if ($odd++ % 2) echo 'style="background: #f8f8f8;"'; ?>>
                    <td align="center"><input type="number" name="config[<?php echo $fd['id_1']; ?>]"
                                              value="<?php echo $fd['id_1_val']; ?>"
                                              size="15"/></td>
                    <td align="center"><input type="number" name="config[<?php echo $fd['id_2']; ?>]"
                                              value="<?php echo $fd['id_2_val']; ?>"
                                              size="15"/></td>
                    <td align="center"><input type="number" name="config[<?php echo $fd['id_3']; ?>]"
                                              value="<?php echo $fd['id_3_val']; ?>" size="15"/></td>
                    <!-- <td align="center"><input type="number" name="config[<?php //echo $fd['id_4']; ?>]" value="<?php //echo $fd['id_4_val']; ?>" size="5"/></td> -->
                </tr>
                <?php if ($fd['end']) echo '<tr><td colspan="4"><hr></td></tr>';
            } ?>

            <tr>
                <td colspan="4" align="right"><input type="submit" style="font-weight:bold;font-size:120%;"
                                                     value="Save changes"/></td>
            </tr>

        <?php } else if ($sub === "pk") { ?>

            <th align="center"><b>Pk</b></th>
            <th align="center"><b>Phí</b></th>

            <?php if ($set_arr) foreach ($set_arr as $df => $fd) { ?>
                <tr <?php if ($odd++ % 2) echo 'style="background: #f8f8f8;"'; ?>>
                    <td align="center">Giết<?php if (!$ok_loop) {
                            echo ' &le; <input type= "number" name="config[' . $fd['id_1'] . ']" value="' . $fd['id_1_val'] . '" size="5"/>';
                        } else {
                            echo ' > ' . $fd['id_1_val'];
                        } ?> mạng
                    </td>
                    <td align="center"><input type="text" name="config[<?php echo $fd['id_2']; ?>]"
                                              value="<?php echo $fd['id_2_val']; ?>"
                                              size="35"/><?php if (!$ok_loop) {
                            echo 'Zen/mạng';
                            $ok_loop = true;
                        } else echo 'V.Point/mạng'; ?></td>
                </tr>
                <?php if ($fd['end']) echo '<tr><td colspan="2"><hr></td></tr>';
            } ?>

            <tr>
                <td colspan="2" align="right"><input type="submit" style="font-weight:bold;font-size:120%;"
                                                     value="Save changes"/></td>
            </tr>

        <?php } ?>


        <!--
    <?php //foreach ($all_templates as $opt_id => $opt_vars)
        {
        //if ($opt_vars[0] == 'title')
        //{
        //  echo '<tr class="o_heading"><td colspan="2">'.$opt_vars['title'].'</td></tr>';
        //continue;
        // }

        ?>
        <tr <?php //if ($odd++%2) echo ' style="background: #f8f8f8;"';
        ?>>
            <td>
                <div class="o_title"><b><?php //echo $opt_id;
        ?></b> <?php //if ($opt_vars['help']) echo '<a href="#" title="'.cn_htmlspecialchars($opt_vars['help']).'" onclick="return(tiny_msg(this));"><sup>?</sup></a>';
        ?></div>
                <div class="o_desc"><?php //echo $opt_vars['desc'];
        ?></div>
            </td>
            <td align="center"><?php

        // echo $opt_vars;
        //if ($opt_vars[0] == 'label') echo cn_htmlspecialchars($opt_vars['var']);
        //elseif ($opt_vars[0] == 'number') echo '<input type="number" name="config['.$opt_id.']" style="width: 400px;" value="'.cn_htmlspecialchars($opt_vars['var']).'"/>';
        // elseif ($opt_vars[0] == 'int')  echo '<input type="number" name="config['.$opt_id.']" size="8" value="'.intval($opt_vars['var']).'"/>';
        //elseif ($opt_vars[0] == 'Y/N') echo '<input type="checkbox" name="config['.$opt_id.']" '.($opt_vars['var']?'checked="checked"' : '').' value="Y"/>';
        // elseif ($opt_vars[0] == 'select')
        //{
        //echo '<select name="config['.$opt_id.']"/>';
        //foreach ($opt_vars[2] as $_id => $_var)
        //echo '<option value="'.cn_htmlspecialchars($_id).'" '.($_id == $opt_vars['var']? 'selected="selected"':'').'>'.cn_htmlspecialchars($_var).'</option>';

        // echo '</select>';
        // }
        ?>
            </td>
			<td>Tên hiển thị nhân vật DarkWizard cấp 2: </td>
			<td><input type="number" name="class_dw_2_name" value="<?php //echo $class_dw_2_name;
        ?>" size="20" maxlength="19"></td>
        </tr>-->
        <?php //}
        ?>


    </table>
</form>


<!-- ----------------------------------- -->

<br/>
<div>
    <ul class="sysconf_top">
        <?php //foreach ($template_parts as $id => $template_name) {
        ?>
        <li <?php //if ($sub == $id) echo 'class="selected"';
        ?>><a href="<?php //echo cn_url_modify('sub='.$id);
            ?>"><?php //echo $template_name;
                ?></a></li>
        <?php } ?>
    </ul>
    <div style="clear: left;"></div>
</div>
