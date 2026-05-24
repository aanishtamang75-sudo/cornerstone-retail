<dl class="row">
    <dt class="col-sm-3">Order ID</dt><dd class="col-sm-9">#<?= (int) $order['id'] ?></dd>
    <dt class="col-sm-3">Status</dt><dd class="col-sm-9"><?= e($order['status']) ?></dd>
    <dt class="col-sm-3">Customer</dt><dd class="col-sm-9"><?= e($order['customer_name']) ?> (<?= e($order['customer_email']) ?>)</dd>
    <dt class="col-sm-3">Total</dt><dd class="col-sm-9">$<?= number_format((float) $order['total'], 2) ?></dd>
    <dt class="col-sm-3">Notes</dt><dd class="col-sm-9"><?= e($order['notes'] ?? '—') ?></dd>
    <dt class="col-sm-3">Placed</dt><dd class="col-sm-9"><?= e($order['created_at']) ?></dd>
    <dt class="col-sm-3">Last updated</dt><dd class="col-sm-9"><?= e($order['updated_at']) ?></dd>
</dl>

<h2 class="h5">Items</h2>
<table class="table">
    <thead><tr><th>Product</th><th>SKU</th><th>Qty</th><th>Unit</th><th>Line</th></tr></thead>
    <tbody>
    <?php foreach ($order['items'] as $item): ?>
        <tr>
            <td><?= e($item['product_name']) ?></td>
            <td><?= e($item['sku']) ?></td>
            <td><?= (int) $item['quantity'] ?></td>
            <td>$<?= number_format((float) $item['unit_price'], 2) ?></td>
            <td>$<?= number_format((float) $item['unit_price'] * (int) $item['quantity'], 2) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php if (\App\Auth::isAdmin()): ?>
    <form method="post" action="<?= url('orders.updateStatus') ?>" class="row g-2 align-items-end">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= (int) $order['id'] ?>">
        <div class="col-auto">
            <label for="status" class="form-label">Update status</label>
            <select class="form-select" id="status" name="status">
                <?php foreach (['pending','processing','shipped','delivered','cancelled'] as $s): ?>
                    <option value="<?= $s ?>" <?= $order['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-auto"><button type="submit" class="btn btn-primary">Save status</button></div>
    </form>
<?php endif; ?>
