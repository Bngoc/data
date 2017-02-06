<?php

list($arr_downlooadShow) = _GL('arr_downlooadShow');
?>

<div class="sub_ranking">
    <table class="ranking" width="100%" align="middle">
        <tr>
            <th class="lbg">TT</th>
            <th>Mô tả</th>
            <th>Dung lượng</th>
            <th>Host Server</th>
            <th class="rbg"><span>Download</span></th>
        </tr>
        <?php foreach ($arr_downlooadShow as $key => $item) {
            echo '<tr><td>' . ($i + 1) . '</td>';
//            if (!empty($item['href'])) {
            echo '<td>' . 0 . '</td>';
            echo '<td>' . ucfirst($item['name']) . '</td>';
            echo '<td>' . $item['href'] .
                '<img border="0" src="<?php echo $img_url; ?>/btn_download.gif"
                             width="86" height="28"></a>
                </td>';
//            }
            echo '</tr>';
        } ?>
    </table>
</div>

<div colspan="3" class="sub_title_1st mg-top15">YÊU CẦU HỆ THỐNG</div>
<div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="100%"
                               height="1px"/></div>

<div class="sub_ranking">
    <table class="ranking" width="100%">
        <tr>
            <th></th>
            <th>Yêu Cầu</th>
        </tr>
        <tr>
            <td>Hệ điều hành</td>
            <td>Windows XP/7/8/8.1/10</td>
        </tr>
        <tr>
        <tr>
            <td>CPU</td>
            <td>Pentium 4 Ghz hoặc cao hơn</td>
        </tr>
        <tr>
            <td>RAM</td>
            <td>1GB hoặc cao hơn</td>
        </tr>
        <tr>
            <td>HDD or SSD</td>
            <td>2GB hoặc cao hơn</td>
        </tr>
        <tr>
            <td>Video Card</td>
            <td>3D graphics processor</td>
        </tr>
        <tr>
            <td>DirectX Version</td>
            <td>DirectX 9.0c hoặc cao hơn</td>
        </tr>
    </table>
</div>