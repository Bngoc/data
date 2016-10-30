<?php
$odd = 0;
list($template_parts, $all_templates, $template_text, $template, $sub, $can_delete, $all_header_conf) = _GL('template_parts, all_templates, template_text, template, sub, can_delete, all_header_conf');

cn_snippet_messages();
cn_snippet_bc();

?>


<ul class="sysconf_top">
    <?php foreach ($all_header_conf as $ID => $ol) { ?>
        <li <?php if ($sub == $ID) echo ' class="selected"'; ?>><a
                href="<?php echo cn_url_modify("sub=$ID"); ?>"><?php echo ucfirst($ID); ?></a></li>
    <?php } ?>
</ul>
<div style="clear: both;"></div>

<form action="<?php echo PHP_SELF; ?>" method="POST">

    <?php cn_form_open('mod, opt, sub'); ?>

    <table class="std-table opt_table">
        <?php
        if ($sub === 'config_class') {
            ?>
            <tr>
                <th>Option name</th>
                <th>Configuration parameter</th>
                <th>Option name</th>
                <th>Configuration parameter</th>
            </tr>
            <tr>
                <td>Mã nhân vật DarkWizard cấp 1:</td>
                <td align="center"><input type="text" name="config[class_dw_1]"
                                          value="<?php echo $all_templates['class_dw_1']; ?>" size="10" maxlength="2">
                </td>
                <td>Tên hiển thị nhân vật DarkWizard cấp 1:</td>
                <td align="center"><input type="word" name="config[class_dw_1_name]"
                                          value="<?php echo $all_templates['class_dw_1_name']; ?>" size="20"
                                          maxlength="19"></td>
            </tr>
            <tr style="background: #f8f8f8;">
                <td>Mã nhân vật DarkWizard cấp 2:</td>
                <td align="center"><input type="text" name="config[class_dw_2]"
                                          value="<?php echo $all_templates['class_dw_2']; ?>" size="10" maxlength="2">
                </td>
                <td>Tên hiển thị nhân vật DarkWizard cấp 2:</td>
                <td align="center"><input type="text" name="config[class_dw_2_name]"
                                          value="<?php echo $all_templates['class_dw_2_name']; ?>" size="20"
                                          maxlength="19"></td>
            </tr>
            <tr>
                <td>Mã nhân vật DarkWizard cấp 3:</td>
                <td align="center"><input type="text" name="config[class_dw_3]"
                                          value="<?php echo $all_templates['class_dw_3']; ?>" size="10" maxlength="2">
                </td>
                <td>Tên hiển thị nhân vật DarkWizard cấp 3:</td>
                <td align="center"><input type="text" name="config[class_dw_3_name]"
                                          value="<?php echo $all_templates['class_dw_3_name']; ?>" size="20"
                                          maxlength="19"></td>
            </tr>
            <tr>
                <td colspan="4">
                    <hr>
                </td>
            </tr>

            <tr style="background: #f8f8f8;">
                <td>Mã nhân vật DarkKnight cấp 1:</td>
                <td align="center"><input type="text" name="config[class_dk_1]"
                                          value="<?php echo $all_templates['class_dk_1']; ?>" size="10" maxlength="2">
                </td>
                <td>Tên hiển thị nhân vật DarkKnight cấp 1:</td>
                <td align="center"><input type="text" name="config[class_dk_1_name]"
                                          value="<?php echo $all_templates['class_dk_1_name']; ?>" size="20"
                                          maxlength="19"></td>
            </tr>
            <tr>
                <td>Mã nhân vật DarkKnight cấp 2:</td>
                <td align="center"><input type="text" name="config[class_dk_2]"
                                          value="<?php echo $all_templates['class_dk_2']; ?>" size="10" maxlength="2">
                </td>
                <td>Tên hiển thị nhân vật DarkKnight cấp 2:</td>
                <td align="center"><input type="text" name="config[class_dk_2_name]"
                                          value="<?php echo $all_templates['class_dk_2_name']; ?>" size="20"
                                          maxlength="19"></td>
            </tr>
            <tr style="background: #f8f8f8;">
                <td>Mã nhân vật DarkKnight cấp 3:</td>
                <td align="center"><input type="text" name="config[class_dk_3]"
                                          value="<?php echo $all_templates['class_dk_3']; ?>" size="10" maxlength="2">
                </td>
                <td>Tên hiển thị nhân vật DarkKnight cấp 3:</td>
                <td align="center"><input type="text" name="config[class_dk_3_name]"
                                          value="<?php echo $all_templates['class_dk_3_name']; ?>" size="20"
                                          maxlength="19"></td>
            </tr>
            <tr>
                <td colspan="4">
                    <hr>
                </td>
            </tr>

            <tr>
                <td>Mã nhân vật ELF cấp 1:</td>
                <td align="center"><input type="text" name="config[class_elf_1]"
                                          value="<?php echo $all_templates['class_elf_1']; ?>" size="10" maxlength="2">
                </td>
                <td>Tên hiển thị nhân vật ELF cấp 1:</td>
                <td align="center"><input type="text" name="config[class_elf_1_name]"
                                          value="<?php echo $all_templates['class_elf_1_name']; ?>" size="20"
                                          maxlength="19"></td>
            </tr>
            <tr style="background: #f8f8f8;">
                <td>Mã nhân vật ELF cấp 2:</td>
                <td align="center"><input type="text" name="config[class_elf_2]"
                                          value="<?php echo $all_templates['class_elf_2']; ?>" size="10" maxlength="2">
                </td>
                <td>Tên hiển thị nhân vật ELF cấp 2:</td>
                <td align="center"><input type="text" name="config[class_elf_2_name]"
                                          value="<?php echo $all_templates['class_elf_2_name']; ?>" size="20"
                                          maxlength="19"></td>
            </tr>
            <tr>
                <td>Mã nhân vật ELF cấp 3:</td>
                <td align="center"><input type="text" name="config[class_elf_3]"
                                          value="<?php echo $all_templates['class_elf_3']; ?>" size="10" maxlength="2">
                </td>
                <td>Tên hiển thị nhân vật ELF cấp 3:</td>
                <td align="center"><input type="text" name="config[class_elf_3_name]"
                                          value="<?php echo $all_templates['class_elf_3_name']; ?>" size="20"
                                          maxlength="19"></td>
            </tr>
            <tr>
                <td colspan="4">
                    <hr>
                </td>
            </tr>

            <tr style="background: #f8f8f8;">
                <td>Mã nhân vật MG cấp 1:</td>
                <td align="center"><input type="text" name="config[class_mg_1]"
                                          value="<?php echo $all_templates['class_mg_1']; ?>" size="10" maxlength="2">
                </td>
                <td>Tên hiển thị nhân vật MG cấp 1:</td>
                <td align="center"><input type="text" name="config[class_mg_1_name]"
                                          value="<?php echo $all_templates['class_mg_1_name']; ?>" size="20"
                                          maxlength="19"></td>
            </tr>
            <tr>
                <td>Mã nhân vật MG cấp 2:</td>
                <td align="center"><input type="text" name="config[class_mg_2]"
                                          value="<?php echo $all_templates['class_mg_2']; ?>" size="10" maxlength="2">
                </td>
                <td>Tên hiển thị nhân vật MG cấp 2:</td>
                <td align="center"><input type="text" name="config[class_mg_2_name]"
                                          value="<?php echo $all_templates['class_mg_2_name']; ?>" size="20"
                                          maxlength="19"></td>
            </tr>
            <tr>
                <td colspan="4">
                    <hr>
                </td>
            </tr>

            <tr style="background: #f8f8f8;">
                <td>Mã nhân vật DarkLord cấp 1:</td>
                <td align="center"><input type="text" name="config[class_dl_1]"
                                          value="<?php echo $all_templates['class_dl_1']; ?>" size="10" maxlength="2">
                </td>
                <td>Tên hiển thị nhân vật DarkLord cấp 1:</td>
                <td align="center"><input type="text" name="config[class_dl_1_name]"
                                          value="<?php echo $all_templates['class_dl_1_name']; ?>" size="20"
                                          maxlength="19"></td>
            </tr>
            <tr>
                <td>Mã nhân vật DarkLord cấp 2:</td>
                <td align="center"><input type="text" name="config[class_dl_2]"
                                          value="<?php echo $all_templates['class_dl_2']; ?>" size="10" maxlength="2">
                </td>
                <td>Tên hiển thị nhân vật DarkLord cấp 2:</td>
                <td align="center"><input type="text" name="config[class_dl_2_name]"
                                          value="<?php echo $all_templates['class_dl_2_name']; ?>" size="20"
                                          maxlength="19"></td>
            </tr>
            <tr>
                <td colspan="4">
                    <hr>
                </td>
            </tr>

            <tr style="background: #f8f8f8;">
                <td>Mã nhân vật Summoner cấp 1:</td>
                <td align="center"><input type="text" name="config[class_sum_1]"
                                          value="<?php echo $all_templates['class_sum_1']; ?>" size="10" maxlength="2">
                </td>
                <td>Tên hiển thị nhân vật Summoner cấp 1:</td>
                <td align="center"><input type="text" name="config[class_sum_1_name]"
                                          value="<?php echo $all_templates['class_sum_1_name']; ?>" size="20"
                                          maxlength="19"></td>
            </tr>
            <tr>
                <td>Mã nhân vật Summoner cấp 2:</td>
                <td align="center"><input type="text" name="config[class_sum_2]"
                                          value="<?php echo $all_templates['class_sum_2']; ?>" size="10" maxlength="2">
                </td>
                <td>Tên hiển thị nhân vật Summoner cấp 2:</td>
                <td align="center"><input type="text" name="config[class_sum_2_name]"
                                          value="<?php echo $all_templates['class_sum_2_name']; ?>" size="20"
                                          maxlength="19"></td>
            </tr>
            <tr style="background: #f8f8f8;">
                <td>Mã nhân vật Summoner cấp 3:</td>
                <td align="center"><input type="text" name="config[class_sum_3]"
                                          value="<?php echo $all_templates['class_sum_3']; ?>" size="10" maxlength="2">
                </td>
                <td>Tên hiển thị nhân vật Summoner cấp 3:</td>
                <td align="center"><input type="text" name="config[class_sum_3_name]"
                                          value="<?php echo $all_templates['class_sum_3_name']; ?>" size="20"
                                          maxlength="19"></td>
            </tr>
            <tr>
                <td colspan="4">
                    <hr>
                </td>
            </tr>

            <tr>
                <td>Mã nhân vật RageFighter cấp 1:</td>
                <td align="center"><input type="text" name="config[class_rf_1]"
                                          value="<?php echo $all_templates['class_rf_1']; ?>" size="10" maxlength="2">
                </td>
                <td>Tên hiển thị nhân vật RageFighter cấp 1:</td>
                <td align="center"><input type="text" name="config[class_rf_1_name]"
                                          value="<?php echo $all_templates['class_rf_1_name']; ?>" size="20"
                                          maxlength="19"></td>
            </tr>
            <tr style="background: #f8f8f8;">
                <td>Mã nhân vật RageFighter cấp 2:</td>
                <td align="center"><input type="text" name="config[class_rf_2]"
                                          value="<?php echo $all_templates['class_rf_2']; ?>" size="10" maxlength="2">
                </td>
                <td>Tên hiển thị nhân vật RageFighter cấp 2:</td>
                <td align="center"><input type="text" name="config[class_rf_2_name]"
                                          value="<?php echo $all_templates['class_rf_2_name']; ?>" size="20"
                                          maxlength="19"></td>
            </tr>
            <tr>
                <td colspan="4">
                    <hr>
                </td>
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
        //elseif ($opt_vars[0] == 'text') echo '<input type="text" name="config['.$opt_id.']" style="width: 400px;" value="'.cn_htmlspecialchars($opt_vars['var']).'"/>';
        // elseif ($opt_vars[0] == 'int')  echo '<input type="text" name="config['.$opt_id.']" size="8" value="'.intval($opt_vars['var']).'"/>';
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
			<td><input type="text" name="class_dw_2_name" value="<?php //echo $class_dw_2_name; 
        ?>" size="20" maxlength="19"></td>
        </tr>-->
        <?php //} 
        ?>

        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2" align="right"><input type="submit" style="font-weight:bold;font-size:120%;"
                                                 value="Save changes"/></td>
        </tr>
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
