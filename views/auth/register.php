<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
        <form method="post" action="<?= url('register') ?>" class="card shadow-sm" novalidate data-validate>
            <?= csrf_field() ?>
            <div class="card-body">
                <div class="mb-3">
                    <label for="full_name" class="form-label">Full name</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" required minlength="2"
                           value="<?= old('full_name') ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required value="<?= old('email') ?>">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required minlength="8">
                </div>
                <div class="mb-3">
                    <label for="password_confirm" class="form-label">Confirm password</label>
                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" required minlength="8">
                </div>
                <button type="submit" class="btn btn-primary w-100">Create account</button>
            </div>
        </form>
    </div>
</div>
