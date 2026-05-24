<?php if ($orders === []): ?>
    <div class="alert alert-secondary" role="status">
        <strong>No orders yet.</strong>
        <?php if (\App\Auth::isAdmin()): ?>
            Customer orders will appear here once users place them.
        <?php else: ?>
            Browse the <a href="<?= url('products.index') ?>">catalogue</a> and check out from your cart to place your first order.
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <?php if (\App\Auth::isAdmin()): ?><th>Customer</th><?php endif; ?>
                <th>Status</th>
                <th>Total</th>
                <th>Created</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $o): ?>
                <tr>
                    <td>#<?= (int) $o['id'] ?></td>
                    <?php if (\App\Auth::isAdmin()): ?>
                        <td><?= e($o['customer_name'] ?? '') ?></td>
                    <?php endif; ?>
                    <td><span class="badge text-bg-secondary"><?= e($o['status']) ?></span></td>
                    <td>$<?= number_format((float) $o['total'], 2) ?></td>
                    <td><?= e($o['created_at']) ?></td>
                    <td><a href="<?= url('orders.show', ['id' => $o['id']]) ?>">View</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
