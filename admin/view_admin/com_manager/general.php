<?php

list($dashboard) = _GL('dashboard');
?>

<div class="wrapper">
    <div class="options">
        <?php foreach ($dashboard as $id => $item) { ?>
            <div class="opt-item">
                <a href="<?php echo cn_url_modify("mod=" . @$item['mod'], "do=" . @$item['do'], "opt=" . @$item['opt']); ?>">
                    <div>
                        <img src="<?php echo getOption('http_script_dir') ?>/skins/images/<?php echo @$item['img']; ?>" width="48"/>
                    </div>
                    <div>
                        <?php echo @$item['name']; ?>
                    </div>
                </a>
            </div>

        <?php } ?>
    </div>

    <div style="clear: both"></div>
</div>







