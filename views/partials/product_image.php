<?php
/** @var array $product */
$src = product_image_src($product['image_url'] ?? null);
$alt = e($product['name'] ?? 'Product');
?>
<?php if ($src): ?>
    <img src="<?= e($src) ?>" alt="<?= $alt ?>" class="card-img-top product-card-img" loading="lazy">
<?php else: ?>
    <div class="product-card-img product-card-img--placeholder" aria-hidden="true">
        <span class="small text-muted">No image</span>
    </div>
<?php endif; ?>
