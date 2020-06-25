<?php
$odd = 0;
list($template_parts, $all_templates, $template_text, $template, $sub, $can_delete, $tuser) = _GL('template_parts, all_templates, template_text, template, sub, can_delete, tuser');

cn_snippet_messages();
cn_snippet_bc();

?>


<ul class="sysconf_top">
    <?php foreach ($all_templates as $ID => $ol) { ?>
        <li <?php if ($sub == $ID) echo ' class="selected"'; ?>><a
                href="<?php echo cn_url_modify("sub=$ID"); ?>"><?php echo ucfirst($ID); ?></a></li>
    <?php } ?>
</ul>
<div style="clear: both;"></div>

<form action="<?php echo PHP_SELF; ?>" method="POST">

    <?php cn_form_open('mod, opt, sub'); ?>

    <table class="std-table opt_table">
        <tr>
            <th>Option name</th>
            <th>Configuration parameter</th>
        </tr>

        <?php foreach ($tuser as $opt_id => $opt_vars) {
            //if ($opt_vars[0] == 'title')
            //{
            //  echo '<tr class="o_heading"><td colspan="2">'.$opt_vars['title'].'</td></tr>';
            //continue;
            // }

            ?>
            <tr <?php if ($odd++ % 2) echo ' style="background: #f8f8f8;"'; ?>>
                <td>
                    <div class="o_title">
                        <b><?php echo $opt_id; ?></b> <?php //if ($opt_vars['help']) echo '<a href="#" title="'.cnHtmlSpecialChars($opt_vars['help']).'" onclick="return(tiny_msg(this));"><sup>?</sup></a>';
                        ?></div>
                    <div class="o_desc"><?php //echo $opt_vars['desc'];
                        ?></div>
                </td>
                <td align="center"><?php

                    echo $opt_vars;
                    //if ($opt_vars[0] == 'label') echo cnHtmlSpecialChars($opt_vars['var']);
                    //elseif ($opt_vars[0] == 'text') echo '<input type="text" name="config['.$opt_id.']" style="width: 400px;" value="'.cnHtmlSpecialChars($opt_vars['var']).'"/>';
                    // elseif ($opt_vars[0] == 'int')  echo '<input type="text" name="config['.$opt_id.']" size="8" value="'.intval($opt_vars['var']).'"/>';
                    //elseif ($opt_vars[0] == 'Y/N') echo '<input type="checkbox" name="config['.$opt_id.']" '.($opt_vars['var']?'checked="checked"' : '').' value="Y"/>';
                    // elseif ($opt_vars[0] == 'select')
                    //{
                    //echo '<select name="config['.$opt_id.']"/>';
                    //foreach ($opt_vars[2] as $_id => $_var)
                    //echo '<option value="'.cnHtmlSpecialChars($_id).'" '.($_id == $opt_vars['var']? 'selected="selected"':'').'>'.cnHtmlSpecialChars($_var).'</option>';

                    // echo '</select>';
                    // }
                    ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td>&nbsp;</td>
            <td align="center"><input type="submit" style="font-weight:bold;font-size:120%;" value="Save changes"/></td>
        </tr>
    </table>
</form>


<!-- ----------------------------------- -->
<form action="<?php echo PHP_SELF; ?>" method="POST">

    <?php cn_form_open('mod, opt, template, sub'); ?>

    <input type="hidden" name="select" value="Y"/>
    <div class="panel">
        <select name="template">
            <?php foreach ($all_templates as $id => $ud) { ?>
                <option
                    value="<?php echo $id; ?>" <?php if ($template == $id) echo 'selected'; ?>><?php echo ucfirst($id); ?></option>
            <?php } ?>
        </select>

        <input type="submit" value="Select template"/>
    </div>

</form>

<br/>
<div>
    <ul class="sysconf_top">
        <?php foreach ($template_parts as $id => $template_name) { ?>
            <li <?php if ($sub == $id) echo 'class="selected"'; ?>><a
                    href="<?php echo cn_url_modify('sub=' . $id); ?>"><?php echo $template_name; ?></a></li>
        <?php } ?>
    </ul>
    <div style="clear: left;"></div>
</div>

<form action="<?php echo PHP_SELF; ?>" method="POST">

    <!-- view template data -->
    <?php if ($template && $sub) { ?>

        <?php cn_form_open('mod, opt, template, sub'); ?>
        <textarea id="template_text" style="width: 100%; height: 480px; font: 12px/1.2em Monospace;"
                  name="save_template_text"><?php echo cnHtmlSpecialChars($template_text); ?></textarea>
        <?php if (getoption('ckeditor2template')) {
            cn_snippet_ckeditor('template_text');
        } ?>

    <?php } ?>

    <!-- template actions -->
    <?php if ($template) { ?>

        <?php cn_form_open('mod, opt, template, sub'); ?>
        <div class="panel">
            <input type="submit" value="Save template"/>
            <input type="text" style="width: 250px;" name="template_name" value=""/>
            <input type="submit" name="create" value="Clone template"/>

            <?php if ($can_delete) { ?>
                <input type="submit" name="delete" value="Delete"/>
            <?php } else { ?>
                <input type="submit" name="reset" value="Reset"/>
            <?php } ?>

            <?php echo cnHtmlSpecialChars(ucfirst($template)); ?>
        </div>

    <?php } ?>
</form>


<div style="text-align: right; margin: 16px 0 0 0">
    <a href="#" onclick="<?php echo cn_snippet_open_win(PHP_SELF . '?mod=help&section=templates'); ?>" class="external">Understanding
        Templates</a>
    &nbsp;&nbsp;
    <a href="#"
       onclick="<?php echo cn_snippet_open_win(PHP_SELF . '?mod=help&section=tplvars', array('w' => 720, 'h' => 640, 'l' => 'auto')); ?>"
       class="external">Template variables</a>
</div>
