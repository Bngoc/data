<?php

list($dashboard, $username, $greeting_message) = _GL('dashboard, username, greeting_message');

//cn_snippet_bc();
?>


<div class="wrapper">

    <h2 style="margin-top: 0;"><?php //echo i18n('Site options'); ?></h2>
    <div class="options">
        <?php foreach ($dashboard as $id => $item) { ?>

            <div class="opt-item">
                <a href="<?php echo cn_url_modify("mod=" . $item['mod'], "opt=" . $item['opt']); ?>">
                    <div><img src="<?php echo getoption('http_script_dir'); ?>/skins/images/<?php echo $item['img']; ?>"
                              width="48"/></div>
                    <div><?php echo $item['name']; ?></div>
                </a>
            </div>

        <?php } ?>
    </div>

    <div style="clear: both"></div>


</div>
<!-------------------------------------------------- -->



