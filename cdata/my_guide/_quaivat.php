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
               fhref="<?php echo cn_url_modify('mod=guide', 'opt=quaivat', "sub=$ID"); ?>"><?php echo ucfirst($ol); ?></a>
        </li>
    <?php } ?>
</ul>
<div class="clear"></div>
<hr><br>

<div class="sub_guide">
    <div id="sub-content">
        <table cellspacing="0" cellpadding="10" align="center" border="1">
            <tbody>
            <tr>
                <td rowspan="4"><img src="/public/images/web/guides/quaivat/images/img11.jpg"></td>
                <td colspan="5">Nhện Độc (Hell Spider )</td>
            </tr>
            <tr>
                <td>Cấp độ</td>
                <td>Lượng máu</td>
                <td>Sức chống đỡ</td>
                <td>Tỉ lệ đỡ thành công</td>
                <td>Sức sát thương</td>
            </tr>
            <tr>
                <td>2</td>
                <td>30</td>
                <td>1</td>
                <td>1</td>
                <td>4 ÷ 7</td>
            </tr>
            <tr>
                <td colspan="5">Nhện độc là loài quái vật cấp thấp mà ta có thể bắt gặp khi đi ngang qua cửa phía Nam
                    của Lorencia. Chúng di chuyển khá nhanh, tiếp cận và tấn công những người mạo hiểm đi qua vùng này
                    theo từng bầy. Sau khi cắn, chúng phun nọc độc vào vết thương. Tuy nhiên chúng lại là loài yếu nhất
                    trong các quái vật của Lục địa MU và rất dễ để hạ gục chúng.
                </td>
            </tr>
            <tr>
                <td rowspan="4"><img src="/public/images/guides/quaivat/images/img19.jpg"></td>
                <td colspan="5">Rồng con (Budge Dragon)</td>
            </tr>
            <tr>
                <td>Cấp độ</td>
                <td>Lượng máu</td>
                <td>Sức chống đỡ</td>
                <td>Tỉ lệ đỡ thành công</td>
                <td>Sức sát thương</td>
            </tr>
            <tr>
                <td>4</td>
                <td>80</td>
                <td>3</td>
                <td>3</td>
                <td>12 ÷ 17</td>
            </tr>
            <tr>
                <td colspan="5">Loài sinh vật này đã sống trên lục địa MU khi KunDun xuất hiện. Tuy hình dạng nhỏ bé
                    nhưng cú đánh của chúng có thể kết liễu bạn.
                </td>
            </tr>
            <tr>
                <td rowspan="4"><img src="/public/images/guides/quaivat/images/img1A.jpg"></td>
                <td colspan="5">Bò chiến (Bull Fighter)</td>
            </tr>
            <tr>
                <td>Cấp độ</td>
                <td>Lượng máu</td>
                <td>Sức chống đỡ</td>
                <td>Tỉ lệ đỡ thành công</td>
                <td>Sức sát thương</td>
            </tr>
            <tr>
                <td>6</td>
                <td>120</td>
                <td>6</td>
                <td>6</td>
                <td>19 ÷ 26</td>
            </tr>
            <tr>
                <td colspan="5">Sống ở Tây Nam Lorencia là một loài quái vật xấu xí, mang hình dạng của con người nhưng
                    lại có sức mạnh và hung hãn vô cùng.
                </td>
            </tr>
            <tr>
                <td rowspan="4"><img src="/public/images/guides/quaivat/images/img1B.jpg"></td>
                <td colspan="5">Chó Săn (Hound)</td>
            </tr>
            <tr>
                <td>Cấp độ</td>
                <td>Lượng máu</td>
                <td>Sức chống đỡ</td>
                <td>Tỉ lệ đỡ thành công</td>
                <td>Sức sát thương</td>
            </tr>
            <tr>
                <td>9</td>
                <td>160</td>
                <td>9</td>
                <td>9</td>
                <td>25 ÷ 35</td>
            </tr>
            <tr>
                <td colspan="5">Phía Bắc và phía Tây Lorencia là nơi sinh sống của một chủng loài săn mồi hung dữ. Bất
                    kỳ ai nếu nghe được tiếng tru của chúng đều không thấy quay về.
                </td>
            </tr>
            <tr>
                <td rowspan="4"><img src="/public/images/guides/quaivat/images/img1C.gif"></td>
                <td colspan="5">Bò Quỷ (Elite Bull Fighter)</td>
            </tr>
            <tr>
                <td>Cấp độ</td>
                <td>Lượng máu</td>
                <td>Sức chống đỡ</td>
                <td>Tỉ lệ đỡ thành công</td>
                <td>Sức sát thương</td>
            </tr>
            <tr>
                <td>12</td>
                <td>220</td>
                <td>12</td>
                <td>12</td>
                <td>35 ÷ 44</td>
            </tr>
            <tr>
                <td colspan="5">Bị con người săn đưổi và KunDun đã lợi dụng điều này biến chúng thành những bề tôi trung
                    thành của y.
                </td>
            </tr>
            <tr>
                <td rowspan="4"><img src="/public/images/guides/quaivat/images/img1E.jpg"></td>
                <td colspan="5">Phù thủy lửa (Lich)</td>
            </tr>
            <tr>
                <td>Cấp độ</td>
                <td>Lượng máu</td>
                <td>Sức chống đỡ</td>
                <td>Tỉ lệ đỡ thành công</td>
                <td>Sức sát thương</td>
            </tr>
            <tr>
                <td>14</td>
                <td>260</td>
                <td>14</td>
                <td>14</td>
                <td>45 ÷ 52</td>
            </tr>
            <tr>
                <td colspan="5">Các phù thủy bị nguyền rủa khi chết đi đã qui hàng KunDun và làm tay sai cho hắn.</td>
            </tr>
            <tr>
                <td rowspan="4"><img src="/public/images/guides/quaivat/images/img1F.jpg"></td>
                <td colspan="5">Quỷ khổng lồ (Giant)</td>
            </tr>
            <tr>
                <td>Cấp độ</td>
                <td>Lượng máu</td>
                <td>Sức chống đỡ</td>
                <td>Tỉ lệ đỡ thành công</td>
                <td>Sức sát thương</td>
            </tr>
            <tr>
                <td>17</td>
                <td>500</td>
                <td>18</td>
                <td>18</td>
                <td>60 ÷ 70</td>
            </tr>
            <tr>
                <td colspan="5">Đây là sự kết hợp hoàn hảo giữa kỹ thuật và phép thuật bóng tối. Hãy cẩn thận khi đến
                    gần những cỗ máy giết người này.
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
