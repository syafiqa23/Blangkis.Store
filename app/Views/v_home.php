<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
    <div>
        <span class="blangkis-eyebrow">Katalog</span>
        <h2 class="mb-1">Koleksi Blangkon Pakis</h2>
        <p class="text-muted mb-0">Pilih produk, cek stok, lalu masukkan ke keranjang.</p>
    </div>
    <a href="<?= base_url('keranjang') ?>" class="btn btn-outline-primary">
        <i class="bi bi-bag-check me-2"></i>Lihat Keranjang
    </a>
</div>

<?php if (empty($product)) : ?>
    <div class="text-center py-5">
        <i class="bi bi-box-seam fs-1 text-muted"></i>
        <h5 class="mt-3">Produk belum tersedia</h5>
        <p class="text-muted">Silakan cek kembali nanti.</p>
    </div>
<?php else : ?>
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
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                            <span class="badge"><?= esc($item['nama_kategori'] ?? 'Blangkon') ?></span>
                            <span class="text-warning small"><i class="bi bi-star-fill"></i> 4.8</span>
                        </div>
                        <h5 class="mb-2"><?= esc($item['nama']) ?></h5>
                        <div class="blangkis-price mb-1"><?= number_to_currency($item['harga'], 'IDR') ?></div>
                        <div class="blangkis-stock mb-3">Stok <?= (int) $item['jumlah'] ?></div>
                        <p class="text-muted small flex-grow-1"><?= esc(substr($item['deskripsi'] ?? '', 0, 120)) ?>...</p>
                        <button type="submit" class="btn btn-primary w-100" <?= (int) $item['jumlah'] <= 0 ? 'disabled' : '' ?>>
                            <i class="bi bi-bag-plus me-2"></i><?= (int) $item['jumlah'] > 0 ? 'Masukkan Keranjang' : 'Stok Habis' ?>
                        </button>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
        <?php endforeach ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
