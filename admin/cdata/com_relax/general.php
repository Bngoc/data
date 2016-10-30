<?php

list($dashboard, $username, $greeting_message) = _GL('dashboard, username, greeting_message');

?>

<div class="wrapper">

    <?php //if (test('Cvm')) { ?>

    <script type="text/javascript">
        function cn_greetings() {
            var display;
            var datetoday = new Date();
            var timenow = datetoday.getTime();

            datetoday.setTime(timenow);
            var thehour = datetoday.getHours();

            if (thehour < 9)      display = "Morning";
            else if (thehour < 12) display = "Day";
            else if (thehour < 17) display = "Afternoon";
            else if (thehour < 20) display = "Evening";
            else display = "Night";

            var greeting = ("Good " + display);
            document.write(greeting);
        }
    </script>
    <div class="greet">
        <script type="text/javascript">cn_greetings();</script>
        , <?php echo $username; ?>! <?php echo $greeting_message; ?></div>

    <?php //} ?>

    <h2 style="margin-top: 0;"><?php // echo i18n('Site options'); ?></h2>
    <div class="options">
        <?php foreach ($dashboard as $id => $item) { ?>

            <div class="opt-item">
                <a href="<?php echo cn_url_modify("mod=" . $item['mod'], "opt=" . $item['opt']); ?>">
                    <div><img src="<?php echo getoption('http_script_dir') ?>/skins/images/<?php echo $item['img']; ?>"
                              width="48"/></div>
                    <div><?php echo $item['name']; ?></div>
                </a>
            </div>

        <?php } ?>
    </div>

    <div style="clear: both"></div>

    <?php //if (test('Cvm')) { ?>

    <!--
        <h2><?php //echo i18n('Misc links'); ?></h2>
        <div class="options">

            <a href="example.php" target="blank">Example</a> &middot;
            <a href="docs/readme.html" target="blank">Readme</a> &middot;
            <a href="docs/usage.html" target="blank">Usage</a> &middot;
            <a href="docs/release.html" target="blank">Release notes</a>

        </div>-->

    <?php cn_checkDisk(); ?>

</div>







