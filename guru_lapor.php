<?php
include 'koneksi.php';

// Ambil data ruangan untuk dropdown
$query_ruangan = mysqli_query($conn, "SELECT * FROM ruangan");

// Proses ketika form laporan dikirim
if (isset($_POST['kirim_laporan'])) {
    $id_ruangan = $_POST['id_ruangan'];
    $id_item    = $_POST['id_item'];
    $deskripsi  = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $status     = 'Pending'; // Status awal laporan

    $query_insert = "INSERT INTO laporan_kerusakan (id_ruangan, id_item, deskripsi_kendala, status_laporan, tanggal_lapor) 
                     VALUES ('$id_ruangan', '$id_item', '$deskripsi', '$status', NOW())";
    
    if (mysqli_query($conn, $query_insert)) {
        $pesan = "Laporan berhasil dikirim ke tim IT secara instan!";
    } else {
        $pesan = "Gagal mengirim laporan: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Pelaporan Kerusakan IT - Al Izhar</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f9f9f9; }
        .container { max-width: 600px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        select, textarea, button { width: 100%; padding: 10px; margin-top: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; }
        button { background-color: #d9534f; color: white; border: none; font-weight: bold; cursor: pointer; }
        button:hover { background-color: #c9302c; }
        .alert { background: #dff0d8; color: #3c763d; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Form Laporan Perangkat IT Rusak</h2>
    <p>Silakan pilih ruangan dan perangkat yang mengalami kendala.</p>

    <?php if (isset($pesan)) { echo "<div class='alert'>$pesan</div>"; } ?>

    <form method="POST" action="">
        <label>Pilih Ruangan:</label>
        <select name="id_ruangan" required>
            <option value="">-- Pilih Ruangan --</option>
            <?php while ($r = mysqli_fetch_assoc($query_ruangan)) { ?>
                <option value="<?= $r['id_ruangan']; ?>"><?= $r['nama_ruangan']; ?></option>
            <?php } ?>
        </select>

        <label>Pilih Item / Alat IT yang Rusak:</label>
        <select name="id_item" required>
            <option value="">-- Pilih Alat di Ruangan --</option>
            <?php
            // Menampilkan list inventaris yang ada di ruangan
            $query_item = mysqli_query($conn, "SELECT * FROM inventaris WHERE status_item = 'Terpasang'");
            while ($i = mysqli_fetch_assoc($query_item)) {
                echo "<option value='{$i['id_item']}'>{$i['nama_item']} ({$i['kategori']})</option>";
            }
            ?>
        </select>

        <label>Deskripsi Kendala / Kerusakan:</label>
        <textarea name="deskripsi" rows="4" placeholder="Contoh: Mouse dan keyboard tidak merespons / klik kanan mati" required></textarea>

        <button type="submit" name="kirim_laporan">Kirim Laporan ke Tim IT</button>
    </form>
</div>

</body>
</html>