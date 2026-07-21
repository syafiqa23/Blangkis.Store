<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan Periodik</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th {
            background-color: #f2f2f2;
        }

        th, td {
            padding: 6px;
            text-align: center;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>
<body>

    <h2>Laporan Penjualan Periodik</h2>

    <p><strong>Periode:</strong> <?= esc(date('d-m-Y', strtotime($awal))) ?> s/d <?= esc(date('d-m-Y', strtotime($akhir))) ?></p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Konsumen</th>
                <th>Jumlah Barang</th>
                <th>Total Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($laporan)) : ?>
                <?php foreach ($laporan as $i => $row) : ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc(date('d-m-Y H:i', strtotime($row['created_at']))) ?></td>
                        <td class="text-left"><?= esc($row['username']) ?></td>
                        <td><?= esc($row['jumlah_barang'] ?? 0) ?></td>
                        <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                        <tr>
    <td colspan="3"><strong>Total Keseluruhan</strong></td>
    <td><strong><?= number_to_currency($total_semua, 'IDR') ?></strong></td>
    <td></td>
</tr>
                        <td>
                            <?php
                                $status = 'Menunggu Pembayaran';
                                if ($row['status_bayar'] === 'lunas' && $row['status_kirim'] === 'sampai') {
                                    $status = 'Selesai';
                                } elseif ($row['status_bayar'] === 'lunas') {
                                    $status = 'Diproses';
                                } elseif ($row['status_kirim'] === 'sampai') {
                                    $status = 'Dikirim (Belum Dibayar)';
                                }
                                echo $status;
                            ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php else : ?>
                <tr>
                    <td colspan="6">Tidak ada data pada periode ini.</td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>

</body>
</html>
