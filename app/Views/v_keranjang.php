<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
    <div>
        <span class="blangkis-eyebrow">Keranjang</span>
        <h2 class="mb-1">Keranjang Belanja</h2>
        <p class="text-muted mb-0">Periksa jumlah produk sebelum checkout.</p>
    </div>
    <a href="<?= base_url('home') ?>" class="btn btn-outline-primary">
        <i class="bi bi-arrow-left me-2"></i>Lanjut Belanja
    </a>
</div>

<?php if (empty($items)) : ?>
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-bag fs-1 text-muted"></i>
            <h5 class="mt-3">Keranjang masih kosong</h5>
            <p class="text-muted">Tambahkan blangkon favorit ke keranjang terlebih dahulu.</p>
            <a href="<?= base_url('home') ?>" class="btn btn-primary">Belanja Sekarang</a>
        </div>
    </div>
<?php else : ?>
    <?= form_open('keranjang/edit') ?>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th style="width: 150px;">Jumlah</th>
                            <th>Subtotal</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($items as $item) : ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="<?= base_url('NiceAdmin/assets/img/' . $item['options']['foto']) ?>" alt="<?= esc($item['name']) ?>" width="76" height="76" class="rounded object-fit-cover">
                                        <div>
                                            <div class="fw-bold"><?= esc($item['name']) ?></div>
                                            <small class="text-muted">Stok tersedia: <?= esc($item['options']['stok'] ?? '-') ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><?= number_to_currency($item['price'], 'IDR') ?></td>
                                <td>
                                    <input type="number" min="1" max="<?= esc($item['options']['stok'] ?? 999) ?>" name="qty<?= $i++ ?>" class="form-control" value="<?= (int) $item['qty'] ?>" required>
                                </td>
                                <td class="fw-bold"><?= number_to_currency($item['subtotal'], 'IDR') ?></td>
                                <td class="text-end">
                                    <a href="<?= base_url('keranjang/delete/' . $item['rowid']) ?>" class="btn btn-outline-secondary btn-sm" onclick="return confirm('Hapus produk ini dari keranjang?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mt-4">
                <div class="p-3 rounded" style="background: var(--blangkis-cream);">
                    <span class="text-muted d-block">Total Belanja</span>
                    <strong class="fs-4"><?= number_to_currency($total, 'IDR') ?></strong>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-outline-primary"><i class="bi bi-arrow-repeat me-2"></i>Perbarui</button>
                    <a class="btn btn-outline-secondary" href="<?= base_url('keranjang/clear') ?>" onclick="return confirm('Kosongkan seluruh keranjang?')">Kosongkan</a>
                    <a class="btn btn-primary" href="<?= base_url('checkout') ?>"><i class="bi bi-credit-card me-2"></i>Checkout</a>
                </div>
            </div>
        </div>
    </div>
    <?= form_close() ?>
<?php endif; ?>

<?= $this->endSection() ?>
