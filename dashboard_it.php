<?php
include 'koneksi.php';

// Proses aksi ketika Tim IT menyelesaikan laporan dan mengganti barang
if (isset($_POST['proses_selesai'])) {
    $id_laporan = $_POST['id_laporan'];
    $id_ruangan = $_POST['id_ruangan'];
    $id_item_rusak = $_POST['id_item_rusak'];
    $id_item_pengganti = $_POST['id_item_pengganti'];

    // 1. Ubah status barang lama (rusak) menjadi 'Rusak' di gudang / lepas dari ruangan
    mysqli_query($conn, "UPDATE inventaris SET status_item = 'Rusak', id_ruangan = NULL WHERE id_item = '$id_item_rusak'");

    // 2. Pasang barang pengganti baru ke ruangan tersebut
    if (!empty($id_item_pengganti)) {
        mysqli_query($conn, "UPDATE inventaris SET status_item = 'Terpasang', id_ruangan = '$id_ruangan' WHERE id_item = '$id_item_pengganti'");
    }

    // 3. Ubah status laporan kerusakan menjadi 'Selesai'
    mysqli_query($conn, "UPDATE laporan_kerusakan SET status_laporan = 'Selesai' WHERE id_laporan = '$id_laporan'");

    $pesan = "Laporan berhasil diselesaikan dan perangkat berhasil diganti!";
}

// Ambil data laporan yang masih Pending
$query_laporan = mysqli_query($conn, "
    SELECT l.*, r.nama_ruangan, i.nama_item, i.kategori 
    FROM laporan_kerusakan l
    JOIN ruangan r ON l.id_ruangan = r.id_ruangan
    JOIN inventaris i ON l.id_item = i.id_item
    WHERE l.status_laporan = 'Pending'
    ORDER BY l.tanggal_lapor DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Tim IT - Al Izhar</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f4f6f9; }
        .container { max-width: 1000px; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; font-size: 14px; }
        th { background-color: #007bff; color: white; }
        select, button { padding: 6px 10px; border-radius: 4px; border: 1px solid #ccc; font-size: 13px; }
        button { background-color: #28a745; color: white; border: none; font-weight: bold; cursor: pointer; }
        button:hover { background-color: #218838; }
        .alert { background: #dff0d8; color: #3c763d; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
        .badge { background: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 12px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Dashboard Tim IT - Kelola Laporan Kerusakan</h2>
    <p>Daftar kendala perangkat IT dari ruangan yang menunggu penanganan.</p>

    <?php if (isset($pesan)) { echo "<div class='alert'>$pesan</div>"; } ?>

    <table>
        <thead>
            <tr>
                <th>Waktu Lapor</th>
                <th>Ruangan</th>
                <th>Perangkat Bermasalah</th>
                <th>Kendala</th>
                <th>Status</th>
                <th>Aksi Penggantian (Dari Gudang)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($query_laporan) > 0) { ?>
                <?php while ($row = mysqli_fetch_assoc($query_laporan)) { ?>
                    <tr>
                        <td><?= $row['tanggal_lapor']; ?></td>
                        <td><strong><?= $row['nama_ruangan']; ?></strong></td>
                        <td><?= $row['nama_item']; ?></td>
                        <td><?= $row['deskripsi_kendala']; ?></td>
                        <td><span class="badge"><?= $row['status_laporan']; ?></span></td>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="id_laporan" value="<?= $row['id_laporan']; ?>">
                                <input type="hidden" name="id_ruangan" value="<?= $row['id_ruangan']; ?>">
                                <input type="hidden" name="id_item_rusak" value="<?= $row['id_item']; ?>">
                                
                                <select name="id_item_pengganti" required>
    <option value="">-- Pilih Unit Cadangan --</option>
    <?php
    $kategori = trim($row['kategori']);
    $query_gudang = mysqli_query($conn, "
        SELECT * FROM inventaris 
        WHERE TRIM(kategori) = '$kategori' 
        AND status_item = 'Tersedia di Gudang' 
        AND kondisi = 'Layak Pakai'
    ");
    
    // INI YANG KURANG: Looping untuk mencetak data gudang ke dalam pilihan dropdown
    while ($gudang = mysqli_fetch_assoc($query_gudang)) {
        echo "<option value='{$gudang['id_item']}'>{$gudang['nama_item']} ({$gudang['kode_aset']})</option>";
    }
    ?>
</select>


                                    
                                </select>
                                <button type="submit" name="proses_selesai">Kirim & Ganti</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="6" style="text-align: center; color: #777;">Tidak ada laporan kerusakan yang pending saat ini. Bagus! 🎉</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>