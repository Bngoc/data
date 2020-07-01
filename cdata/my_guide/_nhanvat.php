<?php

list($sub, $options) = _GL('sub, options');

?>

<ul class="sysconf_top">
    <?php foreach ($options as $ID => $ol) { ?>
        <li <?php echo 'id="' . $ID . '"';
        if ($sub == $ID) {
            echo 'class="selected"';
        } ?>>
            <a id="callAjax" href="javascript:void(0)" idContent="sub-content"
               fhref="<?php echo cn_url_modify('mod=guide', 'opt=nhanvat', "sub=$ID"); ?>"><?php echo ucfirst($ol); ?></a>
        </li>
    <?php } ?>
</ul>
<div class="clear"></div>
<hr><br>
<div class="sub_guide">
    <div id="sub-content">
        <?php echo exec_tpl('-@my_guide/character/' . $sub) ?>
    </div>
</div>
