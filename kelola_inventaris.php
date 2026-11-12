<?php
include 'koneksi.php';

// Proses Tambah Inventaris
if (isset($_POST['tambah_item'])) {
    $kode_aset   = mysqli_real_escape_string($conn, $_POST['kode_aset']);
    $nama_item   = mysqli_real_escape_string($conn, $_POST['nama_item']);
    $kategori    = $_POST['kategori'];
    $kondisi     = $_POST['kondisi'];
    $status_item = $_POST['status_item'];
    $id_ruangan  = !empty($_POST['id_ruangan']) ? $_POST['id_ruangan'] : NULL;

    $query = "INSERT INTO inventaris (kode_aset, nama_item, kategori, kondisi, status_item, id_ruangan) 
              VALUES ('$kode_aset', '$nama_item', '$kategori', '$kondisi', '$status_item', " . ($id_ruangan ? "'$id_ruangan'" : "NULL") . ")";
    
    mysqli_query($conn, $query);
    header("Location: kelola_inventaris.php");
    exit();
}

// Proses Hapus Inventaris
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM inventaris WHERE id_item = '$id'");
    header("Location: kelola_inventaris.php");
    exit();
}

// Ambil data inventaris & ruangan
$query_inventaris = mysqli_query($conn, "
    SELECT i.*, r.nama_ruangan 
    FROM inventaris i 
    LEFT JOIN ruangan r ON i.id_ruangan = r.id_ruangan
    ORDER BY i.id_item DESC
");
$query_ruangan = mysqli_query($conn, "SELECT * FROM ruangan");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Inventaris IT - Al Izhar</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f6f9; }
        .container { max-width: 1100px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 13px; }
        th { background-color: #343a40; color: white; }
        input, select { width: 100%; padding: 8px; margin: 5px 0 12px 0; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { background-color: #007bff; color: white; border: none; padding: 10px 15px; font-weight: bold; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        .btn-danger { background-color: #dc3545; padding: 5px 10px; font-size: 12px; text-decoration: none; color: white; border-radius: 3px; }
        .btn-danger:hover { background-color: #bd2130; }
        .form-box { background: #f8f9fa; padding: 15px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #e9ecef; }
    </style>
</head>
<body>

<div class="container">
    <h2>Manajemen Aset & Inventaris IT</h2>
    <p>Tambah, edit, dan pantau seluruh perangkat IT sekolah beserta status dan lokasinya.</p>

    <!-- Form Tambah Aset -->
    <div class="form-box">
        <h3>+ Tambah Aset Baru</h3>
        <form method="POST" action="">
            <div style="display: flex; gap: 15px;">
                <div style="flex: 1;">
                    <label>Kode Aset:</label>
                    <input type="text" name="kode_aset" placeholder="Contoh: ITPC2026001" required>
                </div>
                <div style="flex: 1;">
                    <label>Nama / Merk Item:</label>
                    <input type="text" name="nama_item" placeholder="Contoh: Monitor Epson 24 inch" required>
                </div>
            </div>
            <div style="display: flex; gap: 15px;">
                <div style="flex: 1;">
                    <label>Kategori:</label>
                    <select name="kategori" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="PC">PC</option>
                        <option value="Laptop">Laptop</option>
                        <option value="Monitor">Monitor</option>
                        <option value="Proyektor">Proyektor</option>
                        <option value="Keyboard/Mouse">Keyboard/Mouse</option>
                        <option value="Printer/Lainnya">Printer/Lainnya</option>
                    </select>
                </div>
                <div style="flex: 1;">
                    <label>Kondisi:</label>
                    <select name="kondisi" required>
                        <option value="Layak Pakai">Layak Pakai</option>
                        <option value="Rusak">Rusak</option>
                        <option value="Junk">Junk (Barang Rongsok/Bangkai)</option>
                    </select>
                </div>
                <div style="flex: 1;">
                    <label>Status & Lokasi:</label>
                    <select name="status_item" required>
                        <option value="Tersedia di Gudang">Tersedia di Gudang</option>
                        <option value="Terpasang">Terpasang di Ruangan</option>
                    </select>
                </div>
                <div style="flex: 1;">
                    <label>Penempatan Ruangan:</label>
                    <select name="id_ruangan">
                        <option value="">-- Kosong (Jika di Gudang) --</option>
                        <?php 
                        mysqli_data_seek($query_ruangan, 0);
                        while($r = mysqli_fetch_assoc($query_ruangan)) { 
                            echo "<option value='{$r['id_ruangan']}'>{$r['nama_ruangan']}</option>";
                        } 
                        ?>
                    </select>
                </div>
            </div>
            <button type="submit" name="tambah_item">Simpan Aset Baru</button>
        </form>
    </div>

    <!-- Tabel Daftar Aset -->
    <h3>Daftar Seluruh Inventaris IT</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Kode Aset</th>
                <th>Nama Perangkat</th>
                <th>Kategori</th>
                <th>Kondisi</th>
                <th>Status</th>
                <th>Lokasi Ruangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($query_inventaris)) { ?>
                <tr>
                    <td><?= $row['id_item']; ?></td>
                    <td><strong><?= $row['kode_aset']; ?></strong></td>
                    <td><?= $row['nama_item']; ?></td>
                    <td><?= $row['kategori']; ?></td>
                    <td><?= $row['kondisi']; ?></td>
                    <td><?= $row['status_item']; ?></td>
                    <td><?= $row['nama_ruangan'] ? $row['nama_ruangan'] : '<span style="color:#888;">Gudang IT</span>'; ?></td>
                    <td>
                        <a href="kelola_inventaris.php?hapus=<?= $row['id_item']; ?>" class="btn-danger" onclick="return confirm('Yakin ingin menghapus aset ini?')">Hapus</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>