<?php if ($items === []): ?>
    <div class="alert alert-secondary" role="status">
        <strong>Your cart is empty.</strong> Add products from the catalogue before checkout.
        <a class="alert-link" href="<?= url('products.index') ?>">Browse products</a>
    </div>
<?php else: ?>
    <form method="post" action="<?= url('cart.update') ?>">
        <?= csrf_field() ?>
        <div class="table-responsive">
            <table class="table align-middle">
                <caption class="visually-hidden">Shopping cart items</caption>
                <thead>
                <tr><th>Product</th><th>Price</th><th>Qty</th><th>Line total</th></tr>
                </thead>
                <tbody>
                <?php foreach ($items as $row): ?>
                    <tr>
                        <td><?= e($row['product']['name']) ?> <span class="text-muted small">(<?= e($row['product']['sku']) ?>)</span></td>
                        <td>$<?= number_format((float) $row['product']['price'], 2) ?></td>
                        <td>
                            <input type="number" class="form-control form-control-sm" style="width:5rem"
                                   name="qty[<?= (int) $row['product']['id'] ?>]" value="<?= (int) $row['quantity'] ?>" min="0"
                                   max="<?= (int) $row['product']['stock'] ?>">
                        </td>
                        <td>$<?= number_format($row['line_total'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr><th colspan="3" class="text-end">Total</th><th>$<?= number_format($total, 2) ?></th></tr>
                </tfoot>
            </table>
        </div>
        <button type="submit" class="btn btn-outline-primary">Update quantities</button>
        <a href="<?= url('cart.clear') ?>" class="btn btn-outline-danger">Clear cart</a>
    </form>

    <form method="post" action="<?= url('orders.checkout') ?>" class="card mt-4" data-validate>
        <?= csrf_field() ?>
        <div class="card-body">
            <h2 class="h5">Checkout</h2>
            <label for="notes" class="form-label">Delivery notes (optional)</label>
            <textarea class="form-control mb-3" id="notes" name="notes" rows="2" maxlength="500"></textarea>
            <button type="submit" class="btn btn-success">Place order</button>
        </div>
    </form>
<?php endif; ?>
