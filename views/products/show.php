<div class="row">
    <?php if (product_image_src($product['image_url'] ?? null)): ?>
        <div class="col-md-4 mb-3 mb-md-0">
            <img src="<?= e(product_image_src($product['image_url'])) ?>" alt="<?= e($product['name']) ?>"
                 class="img-fluid rounded border product-detail-img">
        </div>
    <?php endif; ?>
    <div class="col-lg-<?= product_image_src($product['image_url'] ?? null) ? '8' : '12' ?>">
        <dl class="row">
            <dt class="col-sm-3">SKU</dt><dd class="col-sm-9"><?= e($product['sku']) ?></dd>
            <dt class="col-sm-3">Category</dt><dd class="col-sm-9"><?= e($product['category_name'] ?? '—') ?></dd>
            <dt class="col-sm-3">Price</dt><dd class="col-sm-9">$<?= number_format((float) $product['price'], 2) ?></dd>
            <dt class="col-sm-3">Stock</dt><dd class="col-sm-9"><?= (int) $product['stock'] ?></dd>
            <dt class="col-sm-3">Description</dt><dd class="col-sm-9"><?= nl2br(e($product['description'] ?? '')) ?></dd>
        </dl>
        <?php if (\App\Auth::check() && (int) $product['stock'] > 0): ?>
            <form method="post" action="<?= url('cart.add') ?>" class="d-flex gap-2 align-items-end">
                <?= csrf_field() ?>
                <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
                <div>
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1"
                           max="<?= (int) $product['stock'] ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Add to cart</button>
            </form>
        <?php endif; ?>
    </div>
</div>
