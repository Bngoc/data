<?php

list($result) = _GL('result');
?>
<div class="table-responsive">
    <table class="table" width="100%" cellspacing="1" cellpadding="3" border="0">
        <thead>
        <tr>
            <th>#</th>
            <th>Account</th>
            <th>Character</th>
            <th>PCPoint</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($result as $key => $item) { ?>
            <tr>
                <td align="left"><?= cnHtmlSpecialChars($key) ?></td>
                <td align="left"><?= cnHtmlSpecialChars($item['AccountID']) ?></td>
                <td align="left" title="<?= cnHtmlSpecialChars($item['Name']) ?>"><?= cnHtmlSpecialChars($item['Name']) ?></td>
                <td align="left"><?= $item['SCFPCPoints'] ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
