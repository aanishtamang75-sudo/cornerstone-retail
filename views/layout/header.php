<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? 'Cornerstone Retail') ?> | Cornerstone Retail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= e(rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\')) ?>/assets/css/style.css" rel="stylesheet">
</head>
<body>
<a class="visually-hidden-focusable skip-link" href="#main">Skip to content</a>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary" aria-label="Main navigation">
    <div class="container">
        <a class="navbar-brand fw-semibold" href="<?= url('products.index') ?>">Cornerstone Retail</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain"
                aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="<?= url('products.index') ?>">Catalogue</a></li>
                <?php if (\App\Auth::check()): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= url('cart.index') ?>">Cart</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url('orders.index') ?>">Orders</a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link" href="<?= url('help.index') ?>">Help</a></li>
                <?php if (\App\Auth::isAdmin()): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Admin</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= url('products.create') ?>">Add product</a></li>
                            <li><a class="dropdown-item" href="<?= url('admin.activity') ?>">Activity log</a></li>
                            <li><a class="dropdown-item" href="<?= url('admin.aiLog') ?>">AI log</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php if (\App\Auth::check()): ?>
                    <li class="nav-item"><span class="navbar-text me-2"><?= e(\App\Auth::user()['full_name']) ?>
                        (<?= e(\App\Auth::user()['role']) ?>)</span></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url('logout') ?>">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= url('login') ?>">Log in</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url('register') ?>">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<main id="main" class="container py-4">
    <?php if ($msg = flash('success')): ?>
        <div class="alert alert-success" role="alert"><?= e($msg) ?></div>
    <?php endif; ?>
    <?php if ($msg = flash('error')): ?>
        <div class="alert alert-danger" role="alert"><?= e($msg) ?></div>
    <?php endif; ?>
    <h1 class="h3 mb-4"><?= e($title ?? '') ?></h1>
