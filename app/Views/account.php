<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-xl-9">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row align-items-md-center gap-4 mb-4">
                    <div class="text-center">
                        <?php if (!empty($user['avatar'])) : ?>
                            <img src="<?= base_url('uploads/avatar/' . $user['avatar']) ?>" class="rounded-circle shadow" width="128" height="128" style="object-fit: cover;" alt="Avatar">
                        <?php else : ?>
                            <div class="rounded-circle d-inline-grid place-items-center" style="width:128px;height:128px;background:var(--blangkis-cream);">
                                <i class="bi bi-person fs-1"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="flex-grow-1">
                        <span class="blangkis-eyebrow">Akun Saya</span>
                        <h2 class="mb-1"><?= esc($user['username']) ?></h2>
                        <p class="text-muted mb-0"><?= esc($user['email']) ?></p>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-lg-6">
                        <h5 class="mb-3">Update Avatar</h5>
                        <form action="<?= base_url('account/update-avatar') ?>" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <input type="file" name="avatar" class="form-control" accept=".jpg,.jpeg,.png,.webp" required>
                                <small class="text-muted">JPG, PNG, WEBP. Maksimal 2MB.</small>
                                <div class="invalid-feedback">Pilih file avatar.</div>
                            </div>
                            <button type="submit" class="btn btn-outline-primary">Update Avatar</button>
                        </form>
                    </div>

                    <div class="col-lg-6">
                        <h5 class="mb-3">Data Pengguna</h5>
                        <form action="<?= base_url('account/update-username') ?>" method="post" class="needs-validation" novalidate>
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" value="<?= esc($user['email']) ?>" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" value="<?= esc($user['username']) ?>" class="form-control" required minlength="3">
                                <div class="invalid-feedback">Username minimal 3 karakter.</div>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Username</button>
                        </form>
                    </div>

                    <div class="col-12">
                        <hr>
                        <h5 class="mb-3">Ganti Password</h5>
                        <form action="<?= base_url('account/update-password') ?>" method="post" class="row g-3 needs-validation" novalidate>
                            <?= csrf_field() ?>
                            <div class="col-md-6">
                                <label class="form-label">Password Lama</label>
                                <input type="password" name="password_lama" class="form-control" required minlength="6">
                                <div class="invalid-feedback">Password lama wajib diisi.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password_baru" class="form-control" required minlength="6">
                                <div class="invalid-feedback">Password baru minimal 6 karakter.</div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
