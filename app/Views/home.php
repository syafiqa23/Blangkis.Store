<?= $this->extend('layout_home') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashData('success')) : ?>
    <div class="blangkis-toast alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<?php if (session()->getFlashData('failed')) : ?>
    <div class="blangkis-toast alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('failed') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<nav class="navbar navbar-expand-lg blangkis-navbar fixed-top">
    <div class="container">
        <a href="<?= base_url('/') ?>" class="navbar-brand d-flex align-items-center gap-2">
            <img src="<?= base_url() ?>NiceAdmin/assets/img/logo_blangkon.jpg" alt="Blangkis Store" width="42" height="42" class="rounded-circle">
            <span class="fw-bold">Blangkis Store</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-label="Toggle navigation">
            <i class="bi bi-list fs-2"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <li class="nav-item"><a class="nav-link" href="#home">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">Tentang</a></li>
                <li class="nav-item"><a class="nav-link" href="#products">Produk</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Kontak</a></li>
                <?php if (session()->get('isLoggedIn')) : ?>
                    <li class="nav-item"><a class="btn btn-outline-primary px-3" href="<?= base_url('home') ?>"><i class="bi bi-shop me-1"></i> Masuk Toko</a></li>
                <?php else : ?>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('login') ?>">Login</a></li>
                    <li class="nav-item"><a class="btn btn-primary px-3" href="<?= base_url('register') ?>">Daftar</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<section id="home" class="blangkis-hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="blangkis-eyebrow">UMKM Blangkon Pakis</span>
                <h1>Blangkon pilihan untuk gaya budaya yang tetap modern.</h1>
                <p class="lead">Temukan koleksi blangkon Jawa berkualitas, nyaman dipakai, dan siap menemani acara formal, komunitas, hingga hadiah khas nusantara.</p>
                <div class="d-flex flex-wrap gap-3 mt-4">
                    <a href="#products" class="btn btn-primary btn-lg"><i class="bi bi-bag-check me-2"></i>Belanja Sekarang</a>
                    <a href="#about" class="btn btn-outline-primary btn-lg"><i class="bi bi-info-circle me-2"></i>Tentang UMKM</a>
                </div>
                <div class="row g-3 mt-4">
                    <div class="col-4">
                        <strong>100%</strong>
                        <span>Kurasi produk</span>
                    </div>
                    <div class="col-4">
                        <strong>UMKM</strong>
                        <span>Pakis lokal</span>
                    </div>
                    <div class="col-4">
                        <strong>COD</strong>
                        <span>Data order rapi</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="blangkis-hero-media">
                    <img src="<?= base_url('NiceAdmin/assets/img/blangkon1.jpg') ?>" alt="Blangkon Pakis" class="img-fluid">
                    <div class="blangkis-hero-note">
                        <i class="bi bi-stars"></i>
                        <span>Klasik, rapi, dan nyaman dipakai.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="about" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="blangkis-eyebrow">Kenapa Blangkis?</span>
            <h2 class="fw-bold">Belanja blangkon lebih mudah dan terpercaya</h2>
            <p class="text-muted mb-0">Kualitas produk, proses order, dan komunikasi dibuat sederhana untuk pelanggan UMKM.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card h-100 blangkis-feature">
                    <div class="card-body text-center">
                        <i class="bi bi-shield-check"></i>
                        <h5>Produk Terkurasi</h5>
                        <p>Setiap produk ditampilkan dengan informasi harga, stok, kategori, dan foto yang jelas.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100 blangkis-feature">
                    <div class="card-body text-center">
                        <i class="bi bi-cart-check"></i>
                        <h5>Order Mudah</h5>
                        <p>Keranjang, checkout, bukti pembayaran, dan invoice dibuat mengalir seperti toko online modern.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100 blangkis-feature">
                    <div class="card-body text-center">
                        <i class="bi bi-headset"></i>
                        <h5>Dekat dengan Pelanggan</h5>
                        <p>Kontak, riwayat pesanan, dan status order membantu pelanggan memantau pembelian.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="products" class="py-5 blangkis-product-section">
    <div class="container">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
            <div>
                <span class="blangkis-eyebrow">Koleksi Pilihan</span>
                <h2 class="fw-bold mb-1">Produk Unggulan</h2>
                <p class="text-muted mb-0">Pilih blangkon favorit dan tambahkan ke keranjang.</p>
            </div>
            <a href="<?= base_url('home') ?>" class="btn btn-outline-primary"><i class="bi bi-grid me-2"></i>Lihat Katalog</a>
        </div>
        <div class="row g-4">
            <?php foreach ($product as $item) : ?>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <?= form_open('keranjang') ?>
                    <?= form_hidden('id', $item['id']) ?>
                    <div class="card blangkis-product-card">
                        <div class="ratio ratio-4x3 bg-light">
                            <img src="<?= base_url('NiceAdmin/assets/img/' . $item['foto']) ?>" alt="<?= esc($item['nama']) ?>" class="w-100 h-100 object-fit-cover" loading="lazy">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <span class="badge align-self-start mb-2"><?= esc($item['nama_kategori'] ?? 'Blangkon') ?></span>
                            <h5 class="mb-2"><?= esc($item['nama']) ?></h5>
                            <div class="blangkis-price mb-1"><?= number_to_currency($item['harga'], 'IDR') ?></div>
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="text-warning"><i class="bi bi-star-fill"></i> 4.8</span>
                                <span class="blangkis-stock">Stok <?= (int) $item['jumlah'] ?></span>
                            </div>
                            <p class="text-muted small flex-grow-1"><?= esc(substr($item['deskripsi'] ?? '', 0, 90)) ?>...</p>
                            <button type="submit" class="btn btn-primary w-100" <?= (int) $item['jumlah'] <= 0 ? 'disabled' : '' ?>>
                                <i class="bi bi-bag-plus me-2"></i><?= (int) $item['jumlah'] > 0 ? 'Masukkan Keranjang' : 'Stok Habis' ?>
                            </button>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</section>

<footer id="contact" class="footer py-5">
    <div class="container">
        <div class="row g-4 text-start">
            <div class="col-lg-4">
                <h5 class="text-white mb-3">Blangkis Store</h5>
                <p>UMKM Blangkon Pakis yang menghadirkan produk blangkon dengan kualitas, karakter budaya, dan layanan yang rapi.</p>
                <div class="d-flex gap-3">
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-whatsapp"></i></a>
                    <a href="#"><i class="bi bi-facebook"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-4">
                <h6 class="text-white mb-3">Menu</h6>
                <ul class="list-unstyled d-grid gap-2">
                    <li><a href="#home">Beranda</a></li>
                    <li><a href="#about">Tentang</a></li>
                    <li><a href="#products">Produk</a></li>
                    <li><a href="<?= base_url('login') ?>">Login</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4">
                <h6 class="text-white mb-3">Kontak</h6>
                <ul class="list-unstyled d-grid gap-2">
                    <li><i class="bi bi-geo-alt me-2"></i>Pakis, Malang, Jawa Timur</li>
                    <li><i class="bi bi-telephone me-2"></i>+62 812-3456-7890</li>
                    <li><i class="bi bi-envelope me-2"></i>info@blangkisstore.com</li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4">
                <h6 class="text-white mb-3">Jam Layanan</h6>
                <p>Senin - Sabtu, 08.00 - 20.00 WIB. Pesanan online dapat dibuat kapan saja.</p>
            </div>
        </div>
        <hr class="border-light opacity-25 my-4">
        <p class="text-center mb-0">&copy; <?= date('Y') ?> Blangkis Store. All rights reserved.</p>
    </div>
</footer>

<?= $this->endSection() ?>
