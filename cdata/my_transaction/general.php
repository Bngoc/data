<?php

list($dashboard) = _GL('dashboard');
$km_list = explode('|', getOption('km_list'));

if ($km_list[1]) {
    $strKm = 'Chương trình khuyến mại mọi thẻ nạp: <span class="cRed">' . $km_list[1] . '%</span> cho bất kì mệnh giá nào.';
} else {
    $km_listOne = explode(',', $km_list[0]);

    if ($km_listOne[0]) {
        $strKm = 'Chương trình khuyến mại thẻ nạp VTC: <span class="cRed">' . $km_listOne[0] . ' %</span> cho bất kì mệnh giá nào.';
    } elseif ($km_listOne[1]) {
        $strKm = 'Chương trình khuyến mại thẻ nạp GATE: <span class="cRed">' . $km_listOne[1] . ' %</span> cho bất kì mệnh giá nào.';
    } elseif ($km_listOne[2]) {
        $strKm = 'Chương trình khuyến mại thẻ nạp VIETTEL: <span class="cRed">' . $km_listOne[2] . ' %</span> cho bất kì mệnh giá nào.';
    } elseif ($km_listOne[3]) {
        $strKm = 'Chương trình khuyến mại thẻ nạp MOBI: <span class="cRed">' . $km_listOne[3] . ' %</span> cho bất kì mệnh giá nào.';
    } elseif ($km_listOne[4]) {
        $strKm = 'Chương trình khuyến mại thẻ nạp VINA: <span class="cRed">' . $km_listOne[4] . ' %</span> cho bất kì mệnh giá nào.';
    } else {
        $strKm = '';
    }
}

//cn_snippet_bc();
?>

<div class="wrapper">

    <h2 style="margin-top: 0;">Site options</h2>
    <div class="show_km"><i><?php echo $strKm; ?></i></div>
    <div class="options">
        <?php foreach ($dashboard as $id => $item) { ?>
            <div class="opt-item">
                <a href="<?php echo cn_url_modify("mod=" . $item['mod'], "opt=" . $item['opt'], "token=" . $item['token']); ?>">
                    <div><img
                            src="<?php echo getOption('http_script_dir'); ?>/public/images/<?php echo $item['img']; ?>"
                            width="48"/></div>
                    <div><?php echo $item['name']; ?></div>
                </a>
            </div>

        <?php } ?>
    </div>

    <div style="clear: both"></div>

</div>
