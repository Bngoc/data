<?php

list($result) = _GL('result');
?>
<div class="table-responsive">
    <table class="table" width="100%" cellspacing="1" cellpadding="3" border="0" bgcolor="#0000ff">
        <thead>
        <tr width="100%">
            <th>#</th>
            <th>Account</th>
            <th>Status</th>
            <th>Time</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($result as $key => $item) { ?>
            <tr>
                <td align="left"><?= cnHtmlSpecialChars($key) ?></td>
                <td align="left"><?= cnHtmlSpecialChars($item['Name']) ?></td>
                <td align="left"><?= $item['status'] ?></td>
                <td align="left"
                    title="<?= cnHtmlSpecialChars($item['time']) ?>"><?= cnHtmlSpecialChars($item['time']) ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
