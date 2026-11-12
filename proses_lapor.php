<?php
include 'koneksi.php';

$id_barang = $_POST['id_barang'];
$pelapor = $_POST['nama_pelapor'];

// 1. Masukkan ke tabel laporan
$insert_laporan = mysqli_query($koneksi, "INSERT INTO laporan (id_barang, nama_pelapor) VALUES ('$id_barang', '$pelapor')");

// 2. Update status barang di inventaris menjadi rusak
$update_status = mysqli_query($koneksi, "UPDATE inventaris SET status = 'Rusak' WHERE id_barang = '$id_barang'");

if($insert_laporan && $update_status) {
    echo "<script>alert('Laporan berhasil dikirim ke ruang IT!'); window.location='guru_lapor.php';</script>";
} else {
    echo "Gagal melaporkan!";
}
?>