<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
    <div>
        <span class="blangkis-eyebrow">Kontak</span>
        <h2 class="mb-1">Hubungi Blangkis Store</h2>
        <p class="text-muted mb-0">Kami siap membantu pertanyaan produk, pesanan, dan kerja sama UMKM.</p>
    </div>
</div>

<section class="section contact">
    <div class="row gy-4">
        <div class="col-xl-6">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="info-box card h-100">
                        <i class="bi bi-geo-alt"></i>
                        <h3>Alamat</h3>
                        <p>Pakis, Malang<br>Jawa Timur</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="info-box card h-100">
                        <i class="bi bi-telephone"></i>
                        <h3>Telepon</h3>
                        <p>+62 812-3456-7890<br>+62 878-1234-5678</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="info-box card h-100">
                        <i class="bi bi-envelope"></i>
                        <h3>Email</h3>
                        <p>blangkis.store@gmail.com<br>admin@blangkonpakis.id</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="info-box card h-100">
                        <i class="bi bi-clock"></i>
                        <h3>Jam Operasional</h3>
                        <p>Senin - Sabtu<br>08.00 - 20.00 WIB</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Formulir Kontak</h5>
                    <?= form_open('kontak/kirim', ['class' => 'row g-3 needs-validation', 'novalidate' => true]) ?>
                    <div class="col-md-6">
                        <input type="text" name="name" class="form-control" placeholder="Nama Anda" value="<?= old('name') ?>" required minlength="3">
                        <div class="invalid-feedback">Nama wajib diisi.</div>
                    </div>
                    <div class="col-md-6">
                        <input type="email" class="form-control" name="email" placeholder="Email Anda" value="<?= old('email') ?>" required>
                        <div class="invalid-feedback">Email valid wajib diisi.</div>
                    </div>
                    <div class="col-md-12">
                        <input type="text" class="form-control" name="subject" placeholder="Subjek Pesan" value="<?= old('subject') ?>" required minlength="3">
                        <div class="invalid-feedback">Subjek wajib diisi.</div>
                    </div>
                    <div class="col-md-12">
                        <textarea class="form-control" name="message" rows="6" placeholder="Tulis pesan Anda di sini..." required minlength="10"><?= old('message') ?></textarea>
                        <div class="invalid-feedback">Pesan minimal 10 karakter.</div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary w-100">Kirim Pesan</button>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
