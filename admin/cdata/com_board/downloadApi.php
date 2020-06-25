<?php

//list($list) = _GL('list');
//list($type, $name, $desc, $meta, $group, $req) = _GL('type, name, desc, meta, group, req');

cn_snippet_messages();
cn_snippet_bc();

?>

<form id="upload_form" enctype="multipart/form-data" method="post" action="<?php echo PHP_SELF; ?>">
    <?php cn_form_open('mod, opt'); ?>
    <input type="hidden" name="actionPost" value="1">

    <div>
        <div><label for="image_file">Please select image file</label></div>
        <div><input type="file" name="image_file" id="image_file" onchange=""></div>
        <!--        <div><input type="file" name="image_file" id="image_file" onchange="fileSelected();"></div>-->
    </div>
    <div>
        <input type="button" value="Upload" onclick="startUploading()">
        <!--        <input type="submit" value="Upload">-->
    </div>
    <div id="fileinfo">
        <div id="filename"></div>
        <div id="filesize"></div>
        <div id="filetype"></div>
        <div id="filedim"></div>
    </div>
    <div id="error" style="display: none;">You should select valid image files only!</div>
    <div id="error2" style="display: none;">An error occurred while uploading the file</div>
    <div id="abort" style="display: none;">The upload has been canceled by the user or the browser dropped the
        connection
    </div>
    <div id="warnsize" style="display: none;">Your file is very big. We can't accept it. Please select more small file
    </div>

    <div id="progress_info">
        <div id="progress" style="display: block; width: 90%;"></div>
        <div id="progress_percent">100%</div>
        <div class="clear_both"></div>
        <div>
            <div id="speed">&nbsp;</div>
            <div id="remaining">| 00:00:00</div>
            <div id="b_transfered">194.0 Bytes</div>
            <div class="clear_both"></div>
        </div>
        <div id="upload_response" style="display: block; clear: both; margin-top: 10px"><p>Your file: has been
                successfully received.</p>
            <p>Type: </p>
            <p>Size: 0 </p></div>
    </div>
</form>
