<?php
list($sub, $options, $options_list) = _GL('sub, options, options_list');

if ($sub == 'old-features') {
    $show = 'nenngoc';
} else if ($sub == 'new-features') {
    $show = 'khamngoc';
} else {
    $show = '';
}
?>

<ul class="sysconf_top">
    <?php foreach ($options_list as $ID => $ol) { ?>
        <li <?php if ($sub == $ID) echo ' class="selected"'; ?>>
            <a href="<?php echo cn_url_modify('mod=guide', 'opt=tinhnang', "sub=$ID"); ?>"><?php echo ucfirst($ID); ?></a>
        </li>
    <?php } ?>
</ul>

<div class="sub_guide">
    <div align="right">
        <select name="" id="sub-select" onChange="ajax_load(this.value,'sub-content')">
            <?php foreach ($options as $key => $items) {
                echo '<option value="' . cn_url_modify('mod=guide', 'opt=tinhnang', "sub=$sub", "show=$key") . '">' . $items . '</option>';
            } ?>
        </select>
    </div>
</div>

<div class="clear"></div>
<hr><br>

<div class="sub_guide">
    <div id="sub-content">
        <?php echo exec_tpl('-@my_guide/tinhnang/' . $show) ?>
    </div>
</div>
