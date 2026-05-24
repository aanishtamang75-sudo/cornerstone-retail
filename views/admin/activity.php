<?php if ($entries === []): ?>
    <div class="alert alert-secondary" role="status">
        <strong>No activity logs available.</strong> Actions such as login, product changes, and orders will appear here.
    </div>
<?php else: ?>
<div class="table-responsive">
    <table class="table table-sm table-striped">
        <thead><tr><th>When</th><th>User</th><th>Action</th><th>Entity</th><th>Details</th></tr></thead>
        <tbody>
        <?php foreach ($entries as $e): ?>
            <tr>
                <td><?= e($e['created_at']) ?></td>
                <td><?= e($e['full_name'] ?? 'System') ?></td>
                <td><?= e($e['action']) ?></td>
                <td><?= e($e['entity_type']) ?> #<?= e((string) $e['entity_id']) ?></td>
                <td><?= e($e['details'] ?? '') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
