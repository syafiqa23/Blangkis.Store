<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<?php
if (session()->getFlashData('success')) {
?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
?>
<?php
if (session()->getFlashData('failed')) {
?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('failed') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
?>
<div class="d-flex flex-wrap gap-2 mb-3">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="bi bi-plus-circle me-2"></i>Tambah Data
    </button>
    <a type="button" class="btn btn-outline-primary" href="<?= base_url('admin/produk/download') ?>">
        <i class="bi bi-download me-2"></i>Download Data
    </a>
</div>
<!-- Table with stripped rows -->
<div class="table-responsive">
<table class="table datatable align-middle">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nama</th>
            <th scope="col">Deskripsi</th>
            <th scope="col">Harga</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Foto</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($product as $index => $produk) : ?>
            <tr>
                <th scope="row"><?php echo $index + 1 ?></th>
                <td><?= esc($produk['nama']) ?></td>
                <td><?= esc($produk['deskripsi']) ?></td>
                <td><?= number_to_currency($produk['harga'], 'IDR') ?></td>
                <td><?= (int) $produk['jumlah'] ?></td>
                <td>
                    <?php if ($produk['foto'] != '' and file_exists(FCPATH . "NiceAdmin/assets/img/" . $produk['foto'] . "")) : ?>
                        <img src="<?= base_url("NiceAdmin/assets/img/" . $produk['foto']) ?>" width="86" height="86" class="rounded object-fit-cover" alt="<?= esc($produk['nama']) ?>">
                    <?php endif; ?>
                </td>
                <td>
                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-<?= $produk['id'] ?>">
                        Ubah
                    </button>
                    <a href="<?= base_url('admin/produk/delete/' . $produk['id']) ?>" class="btn btn-outline-secondary btn-sm" onclick="return confirm('Yakin hapus data ini ?')">
                        Hapus
                    </a>
                </td>
            </tr>
            <!-- Edit Modal Begin -->
            <div class="modal fade" id="editModal-<?= $produk['id'] ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= base_url('admin/produk/edit/' . $produk['id']) ?>" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                            <?= csrf_field(); ?>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" name="nama" class="form-control" value="<?= esc($produk['nama']) ?>" placeholder="Nama Barang" required minlength="3">
                                </div>
                                <div class="col-12">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" required minlength="10"><?= esc(old('deskripsi', $produk['deskripsi'])) ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="name">Harga</label>
                                    <input type="number" min="1" name="harga" class="form-control" value="<?= esc($produk['harga']) ?>" placeholder="Harga Barang" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Jumlah</label>
                                    <input type="number" min="0" name="jumlah" class="form-control" value="<?= esc($produk['jumlah']) ?>" placeholder="Jumlah Barang" required>
                                </div>
                                <?php if (!empty($produk['foto'])) : ?>
                                    <img src="<?= base_url("NiceAdmin/assets/img/" . $produk['foto']) ?>" width="100" height="100" class="rounded object-fit-cover" alt="<?= esc($produk['nama']) ?>">
                                <?php endif; ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check" name="check" value="1">
                                    <label class="form-check-label" for="check">
                                        Ceklis jika ingin mengganti foto
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="name">Foto</label>
                                    <input type="file" class="form-control" name="foto" accept=".jpg,.jpeg,.png,.webp">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Edit Modal End -->
        <?php endforeach ?>
    </tbody>
</table>
</div>
<!-- End Table with stripped rows -->

<!-- Add Modal Begin -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/produk') ?>" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama Barang" required minlength="3">
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" placeholder="Deskripsi Produk" required minlength="10"><?= esc(old('deskripsi')) ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="name">Harga</label>
                        <input type="number" min="1" name="harga" class="form-control" placeholder="Harga Barang" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Jumlah</label>
                        <input type="number" min="0" name="jumlah" class="form-control" placeholder="Jumlah Barang" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Foto</label>
                        <input type="file" class="form-control" name="foto" accept=".jpg,.jpeg,.png,.webp">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Modal End -->
<?= $this->endSection() ?>
