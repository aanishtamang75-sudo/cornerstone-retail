<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <form method="post" action="<?= url('login') ?>" class="card shadow-sm" novalidate data-validate>
            <?= csrf_field() ?>
            <div class="card-body">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required
                           value="<?= old('email') ?>" autocomplete="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required minlength="8"
                           autocomplete="current-password">
                </div>
                <button type="submit" class="btn btn-primary w-100">Log in</button>
                <p class="mt-3 mb-0 small">Demo: admin@shop.demo / Admin123! or user@shop.demo / User123!</p>
            </div>
        </form>
    </div>
</div>
