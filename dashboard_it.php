<?php
include 'koneksi.php';

// Proses aksi ketika tim IT men-deploy barang pengganti
if (isset($_POST['proses_ganti'])) {
    $id_laporan = $_POST['id_laporan'];
    $id_item_cadangan = $_POST['id_item_cadangan'];
    $id_item_rusak = $_POST['id_item_rusak'];

    // 1. Ubah status laporan jadi Selesai
    mysqli_query($conn, "UPDATE laporan_kerusakan SET status_laporan = 'Selesai' WHERE id_laporan = '$id_laporan'");

    // 2. Ubah status barang rusak di inventaris menjadi 'Rusak/Perbaikan'
    if(!empty($id_item_rusak)) {
        mysqli_query($conn, "UPDATE inventaris SET status_item = 'Rusak' WHERE id_item = '$id_item_rusak'");
    }

    // 3. Ubah status barang cadangan menjadi 'Terpasang' di ruangan terkait
    // (Bisa dikembangkan lebih lanjut untuk update id_ruangan item cadangan)
    mysqli_query($conn, "UPDATE inventaris SET status_item = 'Terpasang' WHERE id_item = '$id_item_cadangan'");

    $notif = "Penggantian perangkat berhasil diproses dan dikirim ke ruangan!";
}

// Ambil data laporan masuk
$query_tiket = mysqli_query($conn, "SELECT l.*, r.nama_ruangan, i.nama_item as nama_rusak 
                                    FROM laporan_kerusakan l 
                                    JOIN ruangan r ON l.id_ruangan = r.id_ruangan 
                                    LEFT JOIN inventaris i ON l.id_item = i.id_item 
                                    WHERE l.status_laporan = 'Pending'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Tim IT - Al Izhar</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f4f6f9; }
        .container { max-width: 1000px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #007bff; color: white; }
        .btn-deploy { background-color: #28a745; color: white; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; }
        .alert { background: #dff0d8; color: #3c763d; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Dashboard Tim IT - Tiket Kerusakan Masuk</h2>
    <p>Pantau laporan dari setiap ruangan dan lakukan penggantian unit dengan cepat.</p>

    <?php if (isset($notif)) { echo "<div class='alert'>$notif</div>"; } ?>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Ruangan</th>
                <th>Alat Dilaporkan</th>
                <th>Kendala</th>
                <th>Waktu Lapor</th>
                <th>Aksi / Ganti Unit (Inventory)</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            while ($row = mysqli_fetch_assoc($query_tiket)) { 
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><strong><?= $row['nama_ruangan']; ?></strong></td>
                <td><?= $row['nama_rusak'] ?? 'Umum/Lainnya'; ?></td>
                <td><?= $row['deskripsi_kendala']; ?></td>
                <td><?= $row['tanggal_lapor']; ?></td>
                <td>
                    <form method="POST" action="" style="display:inline;">
                        <input type="hidden" name="id_laporan" value="<?= $row['id_laporan']; ?>">
                        <input type="hidden" name="id_item_rusak" value="<?= $row['id_item']; ?>">
                        
                        <select name="id_item_cadangan" required style="padding: 5px;">
                            <option value="">-- Pilih Unit Cadangan di Gudang --</option>
                            <?php
                            // Ambil stok barang yang tersedia di gudang
                            $stok_gudang = mysqli_query($conn, "SELECT * FROM inventaris WHERE status_item = 'Tersedia di Gudang'");
                            while ($sg = mysqli_fetch_assoc($stok_gudang)) {
                                echo "<option value='{$sg['id_item']}'>{$sg['nama_item']} ({$sg['kategori']})</option>";
                            }
                            ?>
                        </select>
                        <button type="submit" name="proses_ganti" class="btn-deploy">Kirim & Ganti</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
            <?php if (mysqli_num_rows($query_tiket) == 0) { ?>
                <tr><td colspan="6" style="text-align: center; color: #777;">Tidak ada tiket kerusakan yang pending saat ini. Mantap!</td></tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>