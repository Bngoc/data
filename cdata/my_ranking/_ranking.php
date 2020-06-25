<?php
list($sub, $class_board, $pagination, $sort, $result_content) = _GL('sub, class_board, pagination, sort, result_content');
list($opt) = _GL('opt');
?>

<ul class="sysconf_top">
    <?php if ($class_board) {
        foreach ($class_board as $ID => $ol) { ?>
            <li <?php echo 'id="' . $ID . '" title="' . $ID . '"';
            if ($sub == $ID) echo 'class="selected"'; ?>>
                <a class="callAjaxRanking" id="callAjaxRanking" href="javascript:void(0)"
                   fhref="<?php echo cn_url_modify('mod=ranking', 'opt=' . $opt, "sub=$ID", 'page', 'per_page'); ?>"><?php echo ucfirst($ol); ?></a>
            </li>
        <?php }
    } elseif (empty($class_board)) {
        echo "<li class='selected cHeddien'><a class=\"callAjaxRanking\" id=\"callAjaxRanking\" href=\"javascript:void(0)\" fhref=\"" . cn_url_modify('mod=ranking', 'opt=' . $opt, 'page', 'per_page') . "\"></a></li>";
    }
    ?>
</ul>
<div class="sortClass col-left">
    <span class="callAjaxRanking <?php echo($sort == 'asc' ? 'bd' : ''); ?>" sort-filter="asc">↑ ASC</span>
    <span class="callAjaxRanking <?php echo($sort == 'desc' ? 'bd' : ''); ?>" sort-filter="desc">↓ DESC</span>
</div>


<div style="clear: both"></div>
<!--box-solid-->
<div class="panel">
    <div id="sub-Content"><?php echo $result_content; ?></div>
    <div class="sub_guide col-right pd-right5">
        <div id="sub-pagination"><?php echo $pagination; ?></div>
    </div>
</div>







