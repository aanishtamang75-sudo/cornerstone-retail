<p class="text-muted">Logs AI suggestions vs what users saved (human-in-the-loop governance).</p>
<?php if ($entries === []): ?>
    <div class="alert alert-secondary" role="status">
        <strong>No AI suggestion logs yet.</strong> Entries appear when an admin uses the Description Assistant on a product form.
    </div>
<?php else: ?>
<div class="table-responsive">
    <table class="table table-sm">
        <thead><tr><th>When</th><th>User</th><th>Feature</th><th>Accepted?</th><th>Input</th><th>Suggested</th><th>Saved</th></tr></thead>
        <tbody>
        <?php foreach ($entries as $e): ?>
            <tr>
                <td><?= e($e['created_at']) ?></td>
                <td><?= e($e['full_name']) ?></td>
                <td><?= e($e['feature']) ?></td>
                <td><?= $e['was_accepted'] ? 'Yes' : 'No' ?></td>
                <td class="small"><?= e(mb_strimwidth($e['input_text'] ?? '', 0, 60, '…')) ?></td>
                <td class="small"><?= e(mb_strimwidth($e['suggested_text'] ?? '', 0, 60, '…')) ?></td>
                <td class="small"><?= e(mb_strimwidth($e['accepted_text'] ?? '', 0, 60, '…')) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
