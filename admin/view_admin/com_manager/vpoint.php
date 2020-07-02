<?php

list($result) = _GL('result');
?>
<div class="table-responsive">
    <table class="table" width="100%" cellspacing="1" cellpadding="3" border="0">
        <thead>
        <tr>
            <th>#</th>
            <th>Account</th>
            <th>Vpoint</th>
            <th>Block</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($result as $key => $item) { ?>
            <tr>
                <td align="left"><?= cnHtmlSpecialChars($key) ?></td>
                <td align="left"><?= cnHtmlSpecialChars($item['memb___id']) ?></td>
                <td align="left" title="<?= cnHtmlSpecialChars($item['vpoint']) ?>"><?= cnHtmlSpecialChars($item['vpoint']) ?></td>
                <td align="left">
                    <?= $item['bloc_code'] === 1 ? __('block') : __('unblock') ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
