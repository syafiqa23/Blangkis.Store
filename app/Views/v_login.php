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
                <h1 class="h3 mb-2">Masuk Akun</h1>
                <p class="text-muted mb-0">Login untuk belanja dan melihat riwayat transaksi.</p>
            </div>

            <?php if (session()->getFlashData('failed')) : ?>
                <div class="alert alert-danger"><?= session()->getFlashData('failed') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashData('error')) : ?>
                <div class="alert alert-danger"><?= session()->getFlashData('error') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashData('success')) : ?>
                <div class="alert alert-success"><?= session()->getFlashData('success') ?></div>
            <?php endif; ?>

            <?= form_open('login', ['class' => 'row g-3 needs-validation', 'novalidate' => true]) ?>
            <div class="col-12">
                <label for="username" class="form-label">Username</label>
                <div class="input-group has-validation">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="username" id="username" class="form-control" value="<?= old('username') ?>" required minlength="3" autocomplete="username">
                    <div class="invalid-feedback">Username wajib diisi.</div>
                </div>
            </div>

            <div class="col-12">
                <label for="passwordInput" class="form-label">Password</label>
                <div class="input-group has-validation">
                    <input type="password" name="password" id="passwordInput" class="form-control" required minlength="6" autocomplete="current-password">
                    <button type="button" class="btn btn-outline-secondary" id="togglePassword" aria-label="Tampilkan password">
                        <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                    </button>
                    <div class="invalid-feedback">Password wajib diisi minimal 6 karakter.</div>
                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </div>
            <div class="col-12">
                <a href="<?= base_url('auth/google') ?>" class="btn btn-outline-primary w-100">
                    <i class="bi bi-google me-2"></i>Login dengan Google
                </a>
            </div>
            <div class="col-12 text-center">
                <p class="small mb-0">Belum punya akun? <a href="<?= base_url('register') ?>">Daftar di sini</a></p>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const togglePassword = document.getElementById("togglePassword");
    const passwordInput = document.getElementById("passwordInput");
    const toggleIcon = document.getElementById("togglePasswordIcon");

    if (togglePassword && passwordInput && toggleIcon) {
        togglePassword.addEventListener("click", function () {
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);
            toggleIcon.classList.toggle("bi-eye");
            toggleIcon.classList.toggle("bi-eye-slash");
        });
    }
});
</script>
<?= $this->endSection() ?>
