<?= $this->extend('components/layout_clear') ?>
<?= $this->section('content') ?>

<section class="auth-shell d-flex align-items-center justify-content-center py-5 px-3">
    <div class="auth-card card">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <a href="<?= base_url('/') ?>" class="d-inline-flex align-items-center justify-content-center gap-2 mb-3">
                    <img src="<?= base_url() ?>NiceAdmin/assets/img/logo_blangkon.jpg" alt="Blangkis Store" width="52" height="52" class="rounded-circle">
                    <span class="fw-bold fs-4">Blangkis Store</span>
                </a>
                <h1 class="h3 mb-2">Buat Akun</h1>
                <p class="text-muted mb-0">Daftar untuk mulai belanja Blangkon Pakis.</p>
            </div>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <?= form_open('register', ['class' => 'row g-3 needs-validation', 'novalidate' => true]) ?>
            <div class="col-12">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= old('name') ?>" required>
                <div class="invalid-feedback">Nama wajib diisi.</div>
            </div>
            <div class="col-12">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= old('email') ?>" required autocomplete="email">
                <div class="invalid-feedback">Masukkan email yang valid.</div>
            </div>
            <div class="col-12">
                <label for="username" class="form-label">Username</label>
                <div class="input-group has-validation">
                    <span class="input-group-text">@</span>
                    <input type="text" name="username" id="username" class="form-control" value="<?= old('username') ?>" required minlength="3" autocomplete="username">
                    <div class="invalid-feedback">Username minimal 3 karakter.</div>
                </div>
            </div>
            <div class="col-12">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required minlength="6" autocomplete="new-password">
                <div class="invalid-feedback">Password minimal 6 karakter.</div>
            </div>
            <div class="col-12">
                <label for="confpassword" class="form-label">Konfirmasi Password</label>
                <input type="password" name="confpassword" id="confpassword" class="form-control" required minlength="6" autocomplete="new-password">
                <div class="invalid-feedback">Konfirmasi password wajib diisi.</div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary w-100">Daftar</button>
            </div>
            <div class="col-12 text-center">
                <p class="small mb-0">Sudah punya akun? <a href="<?= base_url('login') ?>">Login di sini</a></p>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
