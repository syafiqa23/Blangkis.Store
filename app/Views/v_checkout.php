<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
    <div>
        <span class="blangkis-eyebrow">Checkout</span>
        <h2 class="mb-1">Selesaikan Pesanan</h2>
        <p class="text-muted mb-0">Lengkapi alamat, pilih layanan pengiriman, dan upload bukti pembayaran.</p>
    </div>
    <a href="<?= base_url('keranjang') ?>" class="btn btn-outline-primary"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">Data Pengiriman</h5>
                <?= form_open_multipart('buy', ['class' => 'row g-3 needs-validation', 'novalidate' => true]) ?>
                <?= form_hidden('username', session()->get('username')) ?>
                <?= form_input(['type' => 'hidden', 'name' => 'total_harga', 'id' => 'total_harga', 'value' => '']) ?>

                <div class="col-12">
                    <label for="nama" class="form-label">Nama Pemesan</label>
                    <input type="text" class="form-control" id="nama" value="<?= esc(session()->get('username')) ?>" readonly>
                </div>
                <div class="col-12">
                    <label for="alamat" class="form-label">Alamat Lengkap</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required placeholder="Nama jalan, nomor rumah, RT/RW, patokan"><?= old('alamat') ?></textarea>
                    <div class="invalid-feedback">Alamat wajib diisi.</div>
                </div>
                <div class="col-12">
                    <label for="kelurahan" class="form-label">Kelurahan / Kecamatan</label>
                    <select class="form-control" id="kelurahan" name="kelurahan" required></select>
                    <input type="hidden" name="nama_kelurahan" id="nama_kelurahan" value="<?= old('nama_kelurahan') ?>">
                    <div class="invalid-feedback">Pilih kelurahan tujuan.</div>
                </div>
                <div class="col-12">
                    <label for="layanan" class="form-label">Layanan Pengiriman</label>
                    <select class="form-control" id="layanan" name="layanan" required>
                        <option value="">Pilih kelurahan terlebih dahulu</option>
                    </select>
                    <div class="invalid-feedback">Pilih layanan pengiriman.</div>
                </div>
                <div class="col-12">
                    <label for="ongkir" class="form-label">Ongkir</label>
                    <input type="number" class="form-control" id="ongkir" name="ongkir" readonly required value="0">
                </div>
                <div class="col-12">
                    <label for="bukti_pembayaran" class="form-label">Bukti Pembayaran</label>
                    <input type="file" id="bukti_pembayaran" name="bukti_pembayaran" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                    <small class="text-muted">Format jpg, jpeg, png, atau pdf. Maksimal 2MB.</small>
                    <div class="invalid-feedback">Upload bukti pembayaran.</div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-check2-circle me-2"></i>Buat Pesanan</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">Ringkasan Pesanan</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item) : ?>
                                <tr>
                                    <td>
                                        <strong><?= esc($item['name']) ?></strong>
                                        <div class="text-muted small"><?= number_to_currency($item['price'], 'IDR') ?></div>
                                    </td>
                                    <td><?= (int) $item['qty'] ?></td>
                                    <td class="text-end"><?= number_to_currency($item['price'] * $item['qty'], 'IDR') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="d-grid gap-2 mt-3">
                    <div class="d-flex justify-content-between">
                        <span>Subtotal</span>
                        <strong><?= number_to_currency($total, 'IDR') ?></strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Ongkir</span>
                        <strong id="ongkir_label">IDR 0</strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fs-5">
                        <span>Total</span>
                        <strong id="total"><?= number_to_currency($total, 'IDR') ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        var ongkir = 0;
        var subtotal = <?= (float) $total ?>;

        function formatRupiah(value) {
            return 'IDR ' + Number(value || 0).toLocaleString('id-ID');
        }

        function hitungTotal() {
            var total = subtotal + ongkir;
            $("#ongkir").val(ongkir);
            $("#ongkir_label").text(formatRupiah(ongkir));
            $("#total").text(formatRupiah(total));
            $("#total_harga").val(total);
        }

        $('#kelurahan').select2({
            placeholder: 'Ketik minimal 3 huruf...',
            width: '100%',
            ajax: {
                url: '<?= base_url('get-location') ?>',
                dataType: 'json',
                delay: 700,
                data: function(params) {
                    return { search: params.term };
                },
                processResults: function(data) {
                    return {
                        results: (data || []).map(function(item) {
                            return {
                                id: item.id,
                                text: item.subdistrict_name + ", " + item.district_name + ", " + item.city_name + ", " + item.province_name + ", " + item.zip_code
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 3
        });

        $("#kelurahan").on('change', function() {
            var selected = $('#kelurahan').select2('data')[0];
            var idKelurahan = $(this).val();
            $('#nama_kelurahan').val(selected ? selected.text : '');
            $("#layanan").html('<option value="">Memuat layanan...</option>');
            ongkir = 0;
            hitungTotal();

            $.ajax({
                url: "<?= site_url('get-cost') ?>",
                type: 'GET',
                data: { destination: idKelurahan },
                dataType: 'json',
                success: function(data) {
                    $("#layanan").empty().append('<option value="">Pilih layanan</option>');
                    (data || []).forEach(function(item) {
                        var text = item.description + " (" + item.service + ") - estimasi " + item.etd + " hari - " + formatRupiah(item.cost);
                        $("#layanan").append($('<option>', {
                            value: item.service,
                            'data-cost': item.cost,
                            text: text
                        }));
                    });
                },
                error: function() {
                    $("#layanan").html('<option value="">Gagal memuat ongkir</option>');
                }
            });
        });

        $("#layanan").on('change', function() {
            ongkir = parseInt($(this).find(':selected').data('cost')) || 0;
            hitungTotal();
        });

        hitungTotal();
    });
</script>
<?= $this->endSection() ?>
