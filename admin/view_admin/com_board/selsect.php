<?php

list($lang_token, $lang, $list, $tkn, $phraseid, $translate) = _GL('lang_token, lang, list, tkn, phraseid, translate');

$exid = REQ('exid');

cn_snippet_bc();
cn_snippet_messages();

?>
<form action="<?php echo PHP_SELF; ?>" method="POST">
    <table class="panel" width="100%">
        <?php cn_form_open('mod, opt'); ?>
        <input type="hidden" name="sub" value="selectAd">
        <tr>
            <td align="right">Select</td>
            <td colspan="100%"><textarea style="width: 970px;" rows="4" cols="50"
                                         name="phraseid"/> <?php echo $phraseid; ?> </textarea> </td>
        </tr>
        <!--    <tr>-->
        <!--        <td align="right">Option</td>-->
        <!--        <td><input type="radio" checked name="translate" value="0"/> No Warehouse</td>-->
        <!--        <td><input type="radio" name="translate" value="1"/> Yes Warehouse</td>-->
        <!--    </tr>-->
        <tr>
            <td>&nbsp;</td>
            <td><input type="button" value="Execute"/></td>
        </tr>
    </table>
</form>

<div style="overflow-x:auto;">
    <input type="hidden" name="modifica" value="Y"/>
    <br/>
    <table class="std-table" width="100%">
        <tr>
            <th>ID</th>
            <th>Translate</th>
        </tr>
        <?php if (is_array($tkn)) { ?>
            <?php foreach ($tkn as $id => $tran) { ?>
                <tr <?php if ($id == $exid) {
                    echo 'class="row_selected"';
                } ?>>
                    <td>
                        <a href="<?php echo cn_url_modify('lang_token=' . $lang_token, 'exid=' . $id); ?>"><?php echo $id; ?></a>
                    </td>
                    <td><?php echo cnHtmlSpecialChars($tran); ?></td>
                </tr>
            <?php } ?>
        <?php } ?>
    </table>
    <br/>
    <div><input type="submit" name="submit" value="Submit"/></div>
</div>
