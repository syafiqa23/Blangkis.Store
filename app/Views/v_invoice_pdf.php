<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>

<h3 style="text-align:center;">INVOICE</h3>

<p><strong>Nama Pengguna:</strong> <?= esc($transaction['username']) ?></p>
<p><strong>Alamat:</strong> <?= esc($transaction['alamat']) ?></p>
<p><strong>Tanggal Transaksi:</strong> <?= date('d M Y H:i', strtotime($transaction['created_at'])) ?></p>
<p><strong>Status:</strong> <?= $transaction['status'] == 0 ? 'Menunggu Konfirmasi' : 'Diproses' ?></p>
<p><strong>Status Pembayaran:</strong> <?= esc($transaction['status_bayar'] ?? 'Belum Ada') ?></p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Deskripsi</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($details as $index => $item): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= esc($item['nama']) ?></td>
                <td><?= esc($item['deskripsi']) ?></td>
                <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                <td><?= esc($item['jumlah']) ?></td>
                <td>Rp <?= number_format($item['subtotal_harga'], 0, ',', '.') ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="5">Ongkir</th>
            <th>Rp <?= number_format($transaction['ongkir'], 0, ',', '.') ?></th>
        </tr>
        <tr>
            <th colspan="5">Total</th>
            <th>Rp <?= number_format($transaction['total_harga'], 0, ',', '.') ?></th>
        </tr>
    </tfoot>
</table>

</body>
</html>
