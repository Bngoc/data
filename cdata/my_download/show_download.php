<?php

list($arr_downlooadShow) = _GL('arr_downlooadShow');
?>

<div class="sub_ranking">
    <table id="tbl_ranking" width="100%" align="middle">
        <tr>
            <th class="lbg">TT</th>
            <th>Mô tả</th>
            <th>Dung lượng</th>
            <th>Host Server</th>
            <th class="rbg"><span>Download</span></th>
        </tr>
        <?php foreach ($arr_downlooadShow as $key => $item) {
            echo '<tr>
                <td>' . ($i + 1) . '</td>';
            echo '<td>' . $item['href'] .
                '<img border="0" src="<?php echo $img_url; ?>/btn_download.gif"
                             width="86" height="28"></a>
                </td></tr>';
        } ?>
    </table>
</div>

<table style="width: 100%" cellpadding="2" align="middle">
    <tr>
        <td colspan="3" style="padding:20px; text-align:center"></td>
    </tr>
    <tr>
        <td colspan="3" class="sub_title_1st">DOWNLOAD PATCH<br/></td>
    </tr>
    <tr>
        <td colspan="3">
            <div class="vertical-img"><img src="<?php echo $img_url; ?>/vertical-separator.jpg" width="640"
                                           height="1px"/></div>
            <br/></td>
    </tr>
</table>
<div class="sub_ranking">
    <table id="tbl_ranking" width="100%" align="middle">
        <tr>
            <th class="lbg">TT</th>
            <th>Mô tả</th>
            <th>Dung lượng</th>
            <th>Host Server</th>
            <th class="rbg"><span>Download</span></th>
        </tr>
        <?php for ($i = 0; $i < count($dowload_patch); $i++) { ?>
            <tr>
                <td><?php echo $i + 1; ?></td>
                <td><?php echo $dowload_patch[$i][des]; ?></td>
                <td><?php echo $dowload_patch[$i][size]; ?></td>
                <td><strong><?php echo $dowload_patch[$i][host]; ?></strong></td>
                <td><a target="_blank" href="<?php echo $dowload_patch[$i][link]; ?>"><img border="0"
                                                                                           src="<?php echo $img_url; ?>/btn_download.gif"
                                                                                           width="86" height="28"></a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

<table align="middle" style="width: 100%" cellpadding="2">
    <tr>
        <td colspan="3" style="padding:20px; text-align:center"></td>
    </tr>
    <tr>
        <td colspan="3" class="sub_title_1st">PHẦN MỀM HỖ TRỢ<br/></td>
    </tr>
    <tr>
        <td colspan="3">
            <div class="vertical-img"><img src="<?php echo $img_url; ?>/vertical-separator.jpg" width="640"
                                           height="1px"/></div>
            <br/></td>
    </tr>
</table>
<div class="sub_ranking">
    <table id="tbl_ranking">
        <colgroup>
            <col width="50">
            <col width="67">
            <col width="67">
            <col width="111">
            <col width="111">
        </colgroup>
        <thead>
        <tr>
            <th class="lbg">TT</th>
            <th>Mô tả</th>
            <th>Dung lượng</th>
            <th>Host Server</th>
            <th class="rbg"><span>Download</span></th>
        </tr>
        </thead>
        <tbody>
        <?php for ($i = 0; $i < count($dowload_hotro); $i++) { ?>
            <tr>
                <td><?php echo $i + 1; ?></td>
                <td><?php echo $dowload_hotro[$i][des]; ?></td>
                <td><?php echo $dowload_hotro[$i][size]; ?></td>
                <td><strong><?php echo $dowload_hotro[$i][host]; ?></strong></td>
                <td><a target="_blank" href="<?php echo $dowload_hotro[$i][link]; ?>"><img border="0"
                                                                                           src="<?php echo $img_url; ?>/btn_download.gif"
                                                                                           width="86" height="28"></a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<table style="width: 100%" cellpadding="2">
    <tr>
        <td colspan="3" style="padding:20px; text-align:center"></td>
    </tr>
    <tr>
        <td colspan="3" class="sub_title_1st">YÊU CẦU HỆ THỐNG<br/></td>
    </tr>
    <tr>
        <td colspan="3">
            <div class="vertical-img"><img src="<?php echo $img_url; ?>/vertical-separator.jpg" width="640"
                                           height="1px"/></div>
            <br/></td>
    </tr>
</table>

<div class="sub_ranking">
    <table id="tbl_ranking">
        <colgroup>
            <col width="50">
            <col width="67">
            <col width="67">
            <col width="111">
            <col width="111">
        </colgroup>
        <thead>
        <tr>
            <th class="lbg"></th>
            <th>Hệ điều hành</th>
            <th>RAM</th>
            <th>CPU</th>
            <th class="rbg"><span>Graphic Card</span></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>TỐI THIỂU</td>
            <td>Win XP</td>
            <td>512 MB</td>
            <td>Pentium IV 3Ghz</td>
            <td>DirecX 9</td>
        </tr>
        <tr>
            <td>ĐỀ NGHỊ</td>
            <td>Win 7</td>
            <td>1 Gb hoặc cao hơn</td>
            <td>Dual Core 2.2 Ghz hoặc cao hơn</td>
            <td>DirecX 10 hoặc cao hơn</td>
        </tr>
        </tbody>
    </table>
</div>