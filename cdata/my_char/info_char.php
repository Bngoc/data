<?php

list($showchar, $mod) = _GL('showchar, mod');

echo cn_snippet_messages();
?>

<!-------------------------------------------------- -->
<div class="sub_ranking">
    <?php if ($showchar){
    foreach ($showchar as $kr => $val) { ?>
    <table id="tbl_ranking">
        <tr>
            <th class="lbg">Hình ảnh</th>
            <th colspan="2" class="rbg">Thông tin</th>
        </tr>
        <tr class="">
            <td rowspan="8"><img src="<?php echo URL_PATH_IMG . '/class/' . $val['char_image']; ?>.gif"></td>
            <td colspan="2"><b>Tên Nhân vật: <font color="blue">
                        <a href=<?php echo cn_url_modify('mod=char_manager', 'opt=reset', 'sub=' . $val['Name']) . '" title="' . $val['Name'] . '">' . $val['Name']; ?> </a></font></b>
            </td>
        </tr>
        <tr>
            <td style="text-align:left;padding-left: 12px"><b>Cấp độ: <font
                        color="orange"><?php echo $val['level'] ?></font></b></td>
            <td style="text-align:left;padding-left: 12px;"><b>Chủng tộc: <font
                        color="brown"><?php echo $val['cclass'] ?></font></b></td>
        </tr>
        <tr>
            <td style="text-align:left;padding-left: 12px;"><b>Sức mạnh:
                    <?php echo number_format($val['str'], 0, ",", "."); ?></b></td>
            <td style="text-align:left;padding-left: 12px;"><b>Ðiểm chưa cộng: <?php echo $val['point']; ?></b></td>
        </tr>
        <tr>
            <td style="text-align:left;padding-left: 12px;"><b>Nhanh nhẹn:
                    <?php echo number_format($val['dex'], 0, ",", "."); ?></b></td>
            <td style="text-align:left;padding-left: 12px;"><b>Ðiểm dự trữ: <?php echo $val['point_dutru']; ?></b></td>
        </tr>
        <tr>
            <td style="text-align:left;padding-left: 12px;"><b>Sinh lực:
                    <?php echo number_format($val['vit'], 0, ",", "."); ?></b></td>
            <td style="text-align:left;padding-left: 12px;"><b>Ðiểm Phúc
                    Duyên: <?php echo number_format($val['pcpoint'], 0, ",", "."); ?></b></td>
        </tr>
        <tr>
            <td style="text-align:left;padding-left: 12px;"><b>Năng lương
                    : <?php echo number_format($val['ene'], 0, ",", "."); ?></b></td>
            <td style="text-align:left;padding-left: 12px;"><b>Reset: <font
                        color="red"><?php echo $val['reset'] ?></font></b></td>
        </tr>
        <tr>
            <td style="text-align:left;padding-left: 12px;"><b>Mệnh lệnh:
                    <?php echo number_format($val['com'], 0, ",", "."); ?></b></td>
            <td style="text-align:left;padding-left: 12px;"><b>Relife: <font
                        color="green"><?php echo $val['relife'] ?></font></b></td>
        </tr>
        <tr>
            <td style="text-align:left;padding-left: 12px;"><b>Tình trạng ủy Thác:
                </b><?php echo $val['status_uythac']; ?></td>
            <td style="text-align:left;padding-left: 12px;"><b>Ðiểm ủy Thác: <font color="green">
                        <a href="<?php echo cn_url_modify('mod=char_manager', 'opt=rsdelegate', 'sub=' . $val['Name']) . '">' . number_format($val['point_uythac'], 0, ",", "."); ?></a></font></b></td>
		</tr>
	</table>
<?php }
}
else {
    echo '<font color="red"><b>Bạn chưa tạo Nhân vật</b></font>';
} ?>
</div>
