<?php

list($result) = _GL('result');
?>
<div class="table-responsive">
    <table class="table table_wrapper" width="100%" cellspacing="1" cellpadding="3" border="0">
        <thead>
        <tr>
            <th>#</th>
            <th>Query</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($result as $key => $item) { ?>
            <tr>
                <td align="left"><?= cnHtmlSpecialChars($key) ?></td>
                <td align="left"
                    title="<?= cnHtmlSpecialChars($item['query']) ?>"><?= cnHtmlSpecialChars($item['query']) ?></td>
                <td align="left">
                    <?= $item['status'] ? __('done') : __('fail') ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
