<?php

list($log_read, $st, $num, $isfin, $section) = _GL('log_read, st, num,isfin, section');
list($all_shop, $all_character) = _GL('all_shop, all_character');

$st = intval($st);
$num = intval($num);

cn_snippet_bc();
$lopIndx = 0;
$i = 0;

?>

<ul class="sysconf_top">
    <li<?php if (!$section) echo ' class="selected"'; ?>><a href="<?php echo cn_url_modify('section'); ?>">System</a>
    </li>
    <li<?php if ($section === 'character') echo ' class="selected"'; ?>><a
            href="<?php echo cn_url_modify(array('reset'), 'mod=editconfig', 'opt=logs', 'section=character'); ?>">Character</a></li>
</ul>
<?php if (!$section) { ?>


<?php } else { ?>
    <table class="std-table" width="100%">
        <table width="100%" cellspacing="1" cellpadding="3" border="0" bgcolor="#0000ff">
            <tr>
            <?php foreach ($all_shop as $key => $item) {
                echo '<td bgcolor="#ffffcc" width="130" valign="top">';
                echo  '<a href="'. cn_url_modify(array('reset'), 'mod=editconfig', 'opt=logs', 'section=character', 'dir=shop', "sub=". (@$item['log'] ? $item['log'] : '')) .'">' . $item['name'] . '</a>';
                echo  '<div class="xoalog"><a href="'. cn_url_modify(array('reset'), 'mod=editconfig', 'opt=logs', 'section=character', 'dir=shop', "action=". (@$item['log'] ? $item['log'] : '')). '"><font color="#FF0000">Xóa Log</font></div></td>';
                $lopIndx++;
                if ($lopIndx % 7 == 0) {
                    echo '</tr><tr>';
                }
            }
            ?>

        </table>
        <table width="100%" cellspacing="1" cellpadding="3" border="0" bgcolor="#0000ff">
            <tr>
                <td bgcolor="#ffffcc" width="130" valign="top">
                    <?php foreach ($all_character as $key => $item) {
                        echo  '<a href="'. cn_url_modify(array('reset'), 'mod=editconfig', 'opt=logs', 'section=character', 'dir=character', "sub=". (@$item['log'] ? $item['log'] : '')) .'">' . $item['name'] . '</a>';
                        echo  '<div class="xoalog"><a href="'. cn_url_modify(array('reset'), 'mod=editconfig', 'opt=logs', 'section=character', 'dir=character', "action=". (@$item['log'] ? $item['log'] : '')). '"><font color="#FF0000">Xóa Log</font></div><hr>';
                    }
                    ?>
                </td>

                    <td bgcolor="#ffffff" valign="top">
                        <table width="100%" cellspacing="1" cellpadding="3" border="0" bgcolor="#0000ff">
                            <tr>
                                <td width="2%" align="center" bgcolor="#ffffcc"><strong>#</strong></td>
                                <td width="12%" align="center" bgcolor="#ffffcc"><strong>Tài khoản</strong></td>
                                <td width="40%" align="center" bgcolor="#ffffcc"><strong>Nội dung</strong></td>
                                <td width="11%" align="center" bgcolor="#ffffcc"><strong>Gcoin - Vpoint trước</strong></td>
                                <td width="10%" align="center" bgcolor="#ffffcc"><strong>Giao dịch</strong></td>
                                <td width="10%" align="center" bgcolor="#ffffcc"><strong>Gcoin - Vpoint sau</strong></td>
                                <td width="17%" align="center" bgcolor="#ffffcc"><strong>Thời gian</strong></td>
                            </tr>
                            <?php //$vitri = count($log_read)-2; for($i=0;$i<count($log_read);) { ?>
                                <?php //if ( $i >= $page_start ) {?>
                                    <?php //if (!empty($log_read[$i]['account'])) {
                                    foreach ($log_read as $k => $item){?>
                                        <tr style="background:<?php echo ($i%2 ? '#BFB6B3' : '#FFFFFF');?>">
                                            <td align="center" bgcolor=""><?php echo ++$i; ?></td>
                                            <td align="center" bgcolor=""><?php echo $item['account']; ?></td>
                                            <td align="center" bgcolor=""><?php echo $item['content']; ?></td>
                                            <td align="center" bgcolor=""><?php echo $item['gc_vp_before']; ?></td>
                                            <td align="center" bgcolor=""><?php echo $item['gc_vp_gd']; ?></td>
                                            <td align="center" bgcolor=""><?php echo $item['gc_vp_after']; ?></td>
                                            <td align="center" bgcolor=""><?php echo $item['time']; ?></td>
                                        </tr>
                                    <?php //}?>
                                <?php //}?>
                                <?php //$i++; ?>
                                <?php //if ( $i >= $page_end ) break; ?>
                            <?php }?>
                        </table>
                        <table align="center">
                            <tr><?php //echo $list_page; ?></tr>
                        </table>
                    </td>
            </tr>
        </table>
    </table>
<?php }?>


<div>
    <?php
    if ($st - $num >= 0)
        echo '<a href="' . cn_url_modify('st=' . ($st - $num)) . '">&lt;&lt; Prev</a>';
    else
        echo '&lt;&lt; Prev'
    ?>
    &nbsp;[<?php echo $st; ?>]&nbsp;
    <?php
    if (!$isfin)
        echo '<a href="' . cn_url_modify('st=' . ($st + $num)) . '">Next &gt;&gt;</a>';
    else
        echo 'Next &gt;&gt;';
    ?>
<!--    a href="--><?php ///*echo cn_url_modify('st='.($st+$num));*/ ?><!--">Next &gt;&gt;</a-->
</div>

