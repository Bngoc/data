<?php

list($result) = _GL('result');

cn_snippet_messages();
?>
<div class="table-responsive">
    <table class="table table_wrapper" width="100%" cellspacing="1" cellpadding="3" border="0">
        <thead>
        <tr>
            <th>#</th>
            <th>Status</th>
            <th>Query</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($result as $key => $item) { ?>
            <tr>
                <td align="left"><?= cnHtmlSpecialChars($key) ?></td>
                <td align="left"><?= cnHtmlSpecialChars($item['status'] ? __('done') : __('fail')) ?></td>
                <td align="left"
                    title="<?= cnHtmlSpecialChars($item['query']) ?>"><?= cnHtmlSpecialChars($item['query']) ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <div class="row" align="right">
        <form name="restart_game_data" method="post" action="<?php echo REQUEST_URI; ?>">
            <input type="hidden" name="action" id="action" value="restart_game_data">
            <?php foreach ($result as $key => $item) { ?>
                <input type="hidden" name="key_<?= cnHtmlSpecialChars($key) ?>" value="<?= $item['status'] ?>">
            <?php } ?>
            <div class="col-sm-12">
                <select id="class" name="restart_query">
                    <option value="" selected="selected">-- Query --</option>
                    <?php foreach ($result as $key => $item) { ?>
                        <option value="<?= cnHtmlSpecialChars($key) ?>"><?= cnHtmlSpecialChars($key) ?></option>
                    <?php } ?>
                </select>
                <input type="submit" name="Submit" value="Submit">
            </div>
        </form>
    </div>
</div>
