<?php
include 'koneksi.php';

// Ambil data laporan yang sudah berstatus 'Selesai'
$query_riwayat = mysqli_query($conn, "
    SELECT l.*, r.nama_ruangan, i.nama_item, i.kategori, i.kode_aset 
    FROM laporan_kerusakan l
    JOIN ruangan r ON l.id_ruangan = r.id_ruangan
    JOIN inventaris i ON l.id_item = i.id_item
    WHERE l.status_laporan = 'Selesai'
    ORDER BY l.tanggal_lapor DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Laporan Selesai - Al Izhar</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f4f6f9; }
        .container { max-width: 1100px; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; font-size: 13px; }
        th { background-color: #28a745; color: white; }
        .badge { background: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 12px; }
        .btn-back { display: inline-block; margin-bottom: 15px; padding: 8px 12px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; font-size: 13px; }
        .btn-back:hover { background: #5a6268; }
    </style>
</head>
<body>

<div class="container">
    <a href="dashboard_it.php" class="btn-back">&larr; Kembali ke Dashboard IT</a>
    <h2>Riwayat & Log Perbaikan Perangkat IT</h2>
    <p>Daftar seluruh laporan kerusakan yang telah selesai ditangani dan diperbarui oleh Tim IT.</p>

    <table>
        <thead>
            <tr>
                <th>Waktu Lapor</th>
                <th>Ruangan</th>
                <th>Kode Aset</th>
                <th>Perangkat Bermasalah</th>
                <th>Kendala</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($query_riwayat) > 0) { ?>
                <?php while ($row = mysqli_fetch_assoc($query_riwayat)) { ?>
                    <tr>
                        <td><?= $row['tanggal_lapor']; ?></td>
                        <td><strong><?= $row['nama_ruangan']; ?></strong></td>
                        <td><code><?= $row['kode_aset']; ?></code></td>
                        <td><?= $row['nama_item']; ?> (<?= $row['kategori']; ?>)</td>
                        <td><?= $row['deskripsi_kendala']; ?></td>
                        <td><span class="badge"><?= $row['status_laporan']; ?></span></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="6" style="text-align: center; color: #777;">Belum ada riwayat laporan yang selesai.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>