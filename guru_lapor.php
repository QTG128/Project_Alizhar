<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Lapor Kerusakan - Guru</title>
</head>
<body>
    <h2>Form Lapor Kerusakan IT - Ruang SD 204-C</h2>
    <form action="proses_lapor.php" method="POST">
        <label>Nama Guru Pelapor:</label><br>
        <input type="text" name="nama_pelapor" required><br><br>

        <label>Pilih Barang yang Rusak di Ruangan Ini:</label><br>
        <select name="id_barang" required>
            <option value="">-- Pilih Barang --</option>
            <?php
            // Menampilkan hanya barang yang ada di Ruang 1 (SD 204-C) dan kondisinya masih 'Baik'
            $query = mysqli_query($koneksi, "SELECT * FROM inventaris WHERE id_ruangan = 1 AND status = 'Baik'");
            while($data = mysqli_fetch_array($query)){
                echo "<option value='".$data['id_barang']."'>".$data['nama_barang']." (".$data['kode_barang'].")</option>";
            }
            ?>
        </select><br><br>
        
        <button type="submit">Kirim Laporan ke IT</button>
    </form>
</body>
</html>