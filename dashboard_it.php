<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard IT - Al Izhar</title>
</head>
<body>
    <h2>Laporan Masuk (Butuh Tindak Lanjut)</h2>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Waktu Lapor</th>
            <th>Pelapor</th>
            <th>Ruangan</th>
            <th>Barang Rusak</th>
            <th>Aksi IT</th>
        </tr>
        <?php
        // Mengambil data laporan yang masih 'Menunggu' beserta relasi ruangan dan barang
        $query = mysqli_query($koneksi, "
            SELECT l.id_laporan, l.waktu_lapor, l.nama_pelapor, i.nama_barang, r.nama_ruangan 
            FROM laporan l 
            JOIN inventaris i ON l.id_barang = i.id_barang 
            JOIN ruangan r ON i.id_ruangan = r.id_ruangan 
            WHERE l.status_tindak_lanjut = 'Menunggu'
        ");

        while($row = mysqli_fetch_array($query)){
            echo "<tr>";
            echo "<td>".$row['waktu_lapor']."</td>";
            echo "<td>".$row['nama_pelapor']."</td>";
            echo "<td>".$row['nama_ruangan']."</td>";
            echo "<td><b>".$row['nama_barang']."</b></td>";
            echo "<td>";
            
            // Logika instan: Cari stok barang sejenis yang statusnya 'Gudang/Tersedia'
            $keyword_barang = explode(" ", $row['nama_barang'])[0]; // Ambil kata pertama, misal "Monitor"
            $cek_stok = mysqli_query($koneksi, "SELECT * FROM inventaris WHERE nama_barang LIKE '%$keyword_barang%' AND status = 'Gudang/Tersedia' LIMIT 1");
            $stok = mysqli_fetch_array($cek_stok);

            if($stok) {
                echo "<span style='color:green'>Stok Pengganti Ada: ".$stok['nama_barang']." (".$stok['kode_barang'].")</span><br>";
                echo "<button>Tandai Selesai & Kirim Pengganti</button>";
            } else {
                echo "<span style='color:red'>Stok Pengganti Kosong!</span>";
            }
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>