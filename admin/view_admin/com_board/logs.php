<?php

list($log_read, $section, $default_log, $options, $sub) = _GL('log_read, section, default_log, options, sub');
list($all_shop, $all_character, $all_relax, $echoPagination) = _GL('all_shop, all_character, all_relax, echoPagination');

cn_snippet_bc();
$lopIndx = 0;
$i = 0;

?>

<ul class="sysconf_top">

    <?php foreach ($default_log as $key => $ol) { ?>
        <li <?php if ($section == $key || (empty($section) && $key == 'system')) {
            echo ' class="selected"';
        } ?>><a
                href="<?php echo cn_url_modify('mod=editconfig', 'opt=logs', "section=$key", 'sub', 'page', 'action'); ?>"><?php echo ucfirst($key); ?></a>
        </li>
    <?php } ?>
</ul>
<?php if (!$section || $section == 'system') { ?>
    <div style="clear:both;"></div>
    <a style="float: right; margin: 5px;top: 37px; right: 8px; position: absolute;"
       href="<?php echo cn_url_modify('section', 'action=error_dump'); ?>">Xóa Log</a>
    <table id="comparison" style="overflow-x:auto; border-collapse: collapse; display: table; border: 1px solid blue;"
           width="100%" cellspacing="1" cellpadding="3">
        <th style="border: 1px solid blue; width: 3%; padding: 5px; font-weight: 600;" align="left" bgcolor="#ffffcc">
            #
        </th>
        <th style="border: 1px solid blue; width: 5%; padding: 5px; font-weight: 600;" align="left" bgcolor="#ffffcc">
            Status
        </th>
        <th style="border: 1px solid blue; width: 8%; padding: 5px; font-weight: 600;" align="left" bgcolor="#ffffcc">
            Time
        </th>
        <th style="border: 1px solid blue; width: 8%; padding: 5px; font-weight: 600;" align="left" bgcolor="#ffffcc">
            Name
        </th>
        <th style="border: 1px solid blue; width: 7%; padding: 5px; font-weight: 600;" align="left" bgcolor="#ffffcc">
            IP
        </th>
        <th style="border: 1px solid blue; width: 15%;padding: 5px; font-weight: 600;" align="left" bgcolor="#ffffcc">
            URL
        </th>
        <th align="left" style="border: 1px solid blue; padding: 5px; font-weight: 600;" bgcolor="#ffffcc">Error</th>
        <?php
        foreach ($log_read as $k => $item) {
            ?>
            <tr style="background:<?php echo($k % 2 ? '#BFB6B3' : '#FFFFFF'); ?>">
                <td style="border: 1px solid #ddd; overflow-x: scroll" align="middle"><?php echo $item['id']; ?></td>
                <td style="border: 1px solid #ddd; overflow-x: scroll"><?php echo $item['status']; ?></td>
                <td style="border: 1px solid #ddd; overflow-x: scroll"><?php echo $item['time']; ?></td>
                <td style="border: 1px solid #ddd; overflow-x: scroll"><?php echo $item['name']; ?></td>
                <td style="border: 1px solid #ddd; overflow-x: scroll"><?php echo $item['ip']; ?></td>
                <td style="border: 1px solid #ddd; overflow-x: scroll"><?php echo $item['url']; ?></td>
                <td style="border: 1px solid #ddd; overflow-x: scroll"><?php echo $item['error']; ?></td>

            </tr>
            <?php
        } ?>
    </table>
<?php } elseif ($section) {
    echo ' <table width="100%" cellspacing="1" class="sub-log" cellpadding="3" border="0" bgcolor="#0000ff"><tr>';
    foreach ($options as $key => $item) {
        echo '<td class="cust-style" bgcolor="' . (($key == $sub) ? '#c2e9bb' : '#ffffcc') . '" valign="top">';
        echo '<a href="' . cn_url_modify(array('reset'), 'mod=editconfig', 'opt=logs', 'section=' . $section, "sub=$key") . '">' . $item['name'] . '</a>';
        echo '<hr><div class="xoalog"><a href="' . cn_url_modify(array('reset'), 'mod=editconfig', 'opt=logs', 'action', 'section=' . $section, "sub=$key", "action=" . (@$item['log'] ? $item['log'] : '')) . '"><font color="#FF0000">Xóa Log</font></div></td>';
        $lopIndx++;
        if ($lopIndx % 7 == 0) {
            echo '</tr><tr>';
        } ?>

        <?php
    }
    echo '</table>'; ?>
    <div style="clear:both;"></div>
    <table width="100%" bgcolor="#0000ff">
        <tr>
            <td bgcolor="#ffffff" valign="top">
                <table width="100%" cellspacing="1" cellpadding="3" border="0" bgcolor="#0000ff">
                    <tr>
                        <td width="4%" align="center" bgcolor="#ffffcc"><strong>#</strong></td>
                        <td width="9%" align="center" bgcolor="#ffffcc"><strong>Tài khoản</strong></td>
                        <td width="40%" align="center" bgcolor="#ffffcc"><strong>Nội dung</strong></td>
                        <td width="11%" align="center" bgcolor="#ffffcc"><strong>Gcoin - Vpoint trước</strong></td>
                        <td width="10%" align="center" bgcolor="#ffffcc"><strong>Giao dịch</strong></td>
                        <td width="10%" align="center" bgcolor="#ffffcc"><strong>Gcoin - Vpoint sau</strong></td>
                        <td width="17%" align="center" bgcolor="#ffffcc"><strong>Thời gian</strong></td>
                    </tr>
                    <?php
                    foreach ($log_read as $k => $item) {
                        ?>
                        <tr style="background:<?php echo($i % 2 ? '#BFB6B3' : '#FFFFFF'); ?>">
                            <td align="center" bgcolor=""><?php echo $item['id']; ?></td>
                            <td align="center" bgcolor=""><?php echo $item['account']; ?></td>
                            <td align="center" bgcolor=""><?php echo $item['content']; ?></td>
                            <td align="center" bgcolor=""><?php echo $item['gc_vp_before']; ?></td>
                            <td align="center" bgcolor=""><?php echo $item['gc_vp_gd']; ?></td>
                            <td align="center" bgcolor=""><?php echo $item['gc_vp_after']; ?></td>
                            <td align="center" bgcolor=""><?php echo $item['time']; ?></td>
                        </tr>
                        <?php
                    } ?>
                </table>
            </td>
        </tr>
    </table>
    <?php
} ?>

<div>
    <?php
    echo $echoPagination;
    ?>
</div>

