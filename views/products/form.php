<?php
$isEdit = $product !== null;
$action = $isEdit ? url('products.update') : url('products.create');
?>
<form method="post" action="<?= $action ?>" id="productForm" enctype="multipart/form-data" novalidate data-validate>
    <?= csrf_field() ?>
    <?php if ($isEdit): ?><input type="hidden" name="id" value="<?= (int) $product['id'] ?>"><?php endif; ?>

    <div class="row g-3">
        <div class="col-md-6">
            <label for="name" class="form-label">Product name</label>
            <input type="text" class="form-control" id="name" name="name" required
                   value="<?= e($product['name'] ?? old('name')) ?>">
        </div>
        <div class="col-md-6">
            <label for="sku" class="form-label">SKU</label>
            <input type="text" class="form-control" id="sku" name="sku" required
                   value="<?= e($product['sku'] ?? old('sku')) ?>">
        </div>
        <div class="col-md-4">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-select" id="category_id" name="category_id">
                <option value="">—</option>
                <?php foreach ($categories as $c): ?>
                    <?php $sel = ($product['category_id'] ?? old('category_id')) == $c['id']; ?>
                    <option value="<?= (int) $c['id'] ?>" <?= $sel ? 'selected' : '' ?>><?= e($c['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label for="price" class="form-label">Price ($)</label>
            <input type="number" step="0.01" min="0" class="form-control" id="price" name="price" required
                   value="<?= e((string) ($product['price'] ?? old('price'))) ?>">
        </div>
        <div class="col-md-4">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" min="0" class="form-control" id="stock" name="stock" required
                   value="<?= e((string) ($product['stock'] ?? old('stock', '0'))) ?>">
        </div>
        <div class="col-12">
            <label class="form-label">Product image (optional)</label>
            <?php if ($isEdit && product_image_src($product['image_url'] ?? null)): ?>
                <div class="mb-2">
                    <img src="<?= e(product_image_src($product['image_url'])) ?>" alt="Current product image"
                         class="product-form-preview rounded border">
                </div>
            <?php endif; ?>
            <label for="image" class="form-label small">Upload image (JPG, PNG, WebP, GIF — max 2 MB)</label>
            <input type="file" class="form-control mb-2" id="image" name="image" accept="image/jpeg,image/png,image/webp,image/gif">
            <label for="image_url" class="form-label small">Or paste image URL</label>
            <input type="url" class="form-control" id="image_url" name="image_url"
                   placeholder="https://example.com/product.jpg"
                   value="<?= e(
                       ($product && str_starts_with($product['image_url'] ?? '', 'http') ? $product['image_url'] : '')
                           ?: old('image_url')
                   ) ?>">
            <p class="form-text mb-0">Upload takes priority over URL. Leave both empty to keep the current image when editing.</p>
        </div>

        <div class="col-12">
            <div class="card border-info">
                <div class="card-header bg-info-subtle">
                    <strong>AI Description Assistant</strong>
                    <span class="badge text-bg-warning ms-2">Review required</span>
                </div>
                <div class="card-body">
                    <p class="small text-muted"><?= e($ai_disclaimer) ?></p>
                    <label for="draft_notes" class="form-label">Rough notes (keywords, features)</label>
                    <textarea class="form-control mb-2" id="draft_notes" rows="2"
                              placeholder="e.g. soy candles, gift box, 40hr burn"></textarea>
                    <button type="button" class="btn btn-outline-info btn-sm" id="btnSuggestDescription">
                        Generate draft description
                    </button>
                </div>
            </div>
        </div>

        <div class="col-12">
            <label for="description" class="form-label">Description (edit before saving)</label>
            <textarea class="form-control" id="description" name="description" rows="5"><?= e($product['description'] ?? old('description')) ?></textarea>
            <input type="hidden" id="ai_suggested" name="ai_suggested" value="">
            <input type="hidden" id="ai_input" name="ai_input" value="">
        </div>
    </div>

    <div class="mt-4 d-flex gap-2 flex-wrap">
        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Update' : 'Create' ?> product</button>
        <a href="<?= url('products.index') ?>" class="btn btn-outline-secondary">Cancel</a>
    </div>
</form>
<?php if ($isEdit): ?>
    <form method="post" action="<?= url('products.delete') ?>" class="mt-2"
          onsubmit="return confirm('Delete this product permanently?');">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= (int) $product['id'] ?>">
        <button type="submit" class="btn btn-outline-danger btn-sm">Delete product</button>
    </form>
<?php endif; ?>

<script>
window.AI_SUGGEST_URL = <?= json_encode(url('ai.suggestDescription')) ?>;
window.AI_LOG_URL = <?= json_encode(url('ai.logAcceptance')) ?>;
window.CSRF = <?= json_encode(csrf_token()) ?>;
</script>
