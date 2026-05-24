<?php $p = $products; ?>
<form method="get" action="<?= url('products.index') ?>" class="card mb-4" role="search">
    <input type="hidden" name="route" value="products.index">
    <div class="card-body row g-3 align-items-end">
        <div class="col-md-4">
            <label for="q" class="form-label">Search</label>
            <input type="search" class="form-control" id="q" name="q" placeholder="Name or SKU"
                   value="<?= e($filters['q']) ?>">
        </div>
        <div class="col-md-2">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-select" id="category_id" name="category_id">
                <option value="">All</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= (int) $c['id'] ?>" <?= $filters['category_id'] == $c['id'] ? 'selected' : '' ?>>
                        <?= e($c['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label for="min_price" class="form-label">Min price</label>
            <input type="number" step="0.01" min="0" class="form-control" id="min_price" name="min_price"
                   value="<?= e($filters['min_price']) ?>">
        </div>
        <div class="col-md-2">
            <label for="max_price" class="form-label">Max price</label>
            <input type="number" step="0.01" min="0" class="form-control" id="max_price" name="max_price"
                   value="<?= e($filters['max_price']) ?>">
        </div>
        <div class="col-md-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="in_stock" name="in_stock" value="1"
                    <?= $filters['in_stock'] === '1' ? 'checked' : '' ?>>
                <label class="form-check-label" for="in_stock">In stock only</label>
            </div>
            <button type="submit" class="btn btn-primary mt-2 w-100">Filter</button>
        </div>
    </div>
</form>

<p class="text-muted"><?= (int) $p['total'] ?> product(s) found</p>

<?php if ($p['items'] === []): ?>
    <?php
    $hasFilters = $filters['q'] !== '' || $filters['category_id'] !== ''
        || $filters['min_price'] !== '' || $filters['max_price'] !== '' || $filters['in_stock'] === '1';
    ?>
    <div class="alert alert-secondary" role="status">
        <?php if ($hasFilters): ?>
            <strong>No products found.</strong> Nothing matches your current search or filters. Try clearing filters or another keyword.
        <?php else: ?>
            <strong>No products found.</strong> The catalogue is empty. An admin can add products from the Admin menu.
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($p['items'] as $product): ?>
            <div class="col">
                <article class="card h-100 shadow-sm">
                    <?php require BASE_PATH . '/views/partials/product_image.php'; ?>
                    <div class="card-body d-flex flex-column">
                        <h2 class="h6 card-title"><?= e($product['name']) ?></h2>
                        <p class="small text-muted mb-1"><?= e($product['sku']) ?> · <?= e($product['category_name'] ?? 'Uncategorised') ?></p>
                        <p class="card-text flex-grow-1"><?= e(mb_strimwidth($product['description'] ?? '', 0, 100, '…')) ?></p>
                        <p class="fw-bold mb-2">$<?= number_format((float) $product['price'], 2) ?>
                            <span class="badge bg-<?= (int) $product['stock'] > 0 ? 'success' : 'secondary' ?>">
                                <?= (int) $product['stock'] ?> in stock
                            </span>
                        </p>
                        <div class="d-flex gap-2">
                            <a class="btn btn-outline-primary btn-sm" href="<?= url('products.show', ['id' => $product['id']]) ?>">View</a>
                            <?php if (\App\Auth::check() && (int) $product['stock'] > 0): ?>
                                <form method="post" action="<?= url('cart.add') ?>" class="d-inline">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Add to cart</button>
                                </form>
                            <?php endif; ?>
                            <?php if (\App\Auth::isAdmin()): ?>
                                <a class="btn btn-outline-secondary btn-sm" href="<?= url('products.edit', ['id' => $product['id']]) ?>">Edit</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if ($p['total_pages'] > 1): ?>
        <nav class="mt-4" aria-label="Product pagination">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $p['total_pages']; $i++): ?>
                    <li class="page-item <?= $i === $p['page'] ? 'active' : '' ?>">
                        <a class="page-link" href="<?= url('products.index', array_merge($filters, ['page' => $i])) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
<?php endif; ?>
