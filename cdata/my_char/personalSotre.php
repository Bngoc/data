<?php

list($sub, $showchar, $show_warehouse) = _GL('sub, showchar, show_warehouse');
cn_snippet_messages();
?>


<table style="width: 100%" cellpadding="2">
    <form action="<?php echo PHP_SELF; ?>" method="GET">
        <?php cn_snippet_get_hidden(); ?>
        <tr>
            <td colspan="3" class="">THÔNG TIN HÒM ĐỒ CÁ NHÂN<br/></td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="100%"
                                               height="1px"/></div>
                <br/></td>
        </tr>
        <tr>
            <td colspan="3">
                <?php echo $show_warehouse;?>
            </td>
        </tr>
        <tr><td colspan="3"></td></tr>
        <tr>
            <td class="bizwebform_col_1 pd-top15 pd-bottom15">Chọn Nhân vật</td>
            <td class="bizwebform_col_2 pd-top15 pd-bottom15">
                <select size="1" name="sub" id="bizwebselect" onchange='submit()'>
                    <?php if ($showchar) foreach ($showchar as $name => $val) { ?>
                        <option
                            value="<?php echo $name; ?>"<?php if ($sub == $name) echo 'selected'; ?>>
                            <?php echo $name ?>( LV: <?php echo $val['level'] ?> - Reset: <?php echo $val['reset'] ?>
                            - Đã Relife <?php echo $val['relife'] ?>)
                        </option>
                    <?php } ?>
                </select>

            </td>
            <td class="bizwebform_col_3"></td>
        </tr>
    </form>

    <form id="verify" action="<?php echo PHP_SELF; ?>" method="POST"  onSubmit="return validateFormOnSubmit();">
        <?php echo cn_form_open('mod, opt, sub'); ?>
        <input type="hidden" value="action_personalSotre" name="action_personalSotre"/>
        <tr>
            <td colspan="3" class="">MÃ XÁC NHẬN</td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="100%"
                                               height="1px"/></div>
                <br/></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1"><a href="#" style="border-bottom: 1px dotted #000080;" onclick="getId('capchaWeb')
                    . src='<?php echo getoption('http_script_dir'); ?>/captcha.php?page=web&r='+Math.random(); return(false);">
                    Refresh code</a></td>
            <td colspan="" class="bizwebform_col_2" style="padding-left:20px;">
                <div class="vertical-img"><img src="<?php echo getoption('http_script_dir'); ?>/captcha.php?cap=web"
                                               id="capchaWeb" alt=""></div>
            </td>
            <td class="bizwebform_col_3"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Nhập mã xác nhận <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input type="text" class="bizwebform" name="verifyCaptcha" required
                                                onchange="checkCaptcha(this.value, 'msg_Captcha');"/></td>
            <td class="bizwebform_col_3" id="msg_Captcha"></td>
        </tr>
        <tr>
            <td colspan="3" style="padding:20px; text-align:center"></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align:center">
                <input type="image" src="<?php echo URL_PATH_IMG; ?>/capnhat.png" style="padding-right:10px">
                <img style="cursor:pointer" border="0" src="<?php echo URL_PATH_IMG; ?>/cancel.png"
                     onclick="document.getElementById('verify').reset();" style="padding-left:10px">
            </td>
        </tr>
    </form>
</table>


