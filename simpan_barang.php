<?php
include 'koneksi.php';

$nama = $_POST['nama'];
$harga = $_POST['harga'];
$kategori = $_POST['kategori'];

$gambar = $_FILES['gambar']['name'];
$tmp = $_FILES['gambar']['tmp_name'];

move_uploaded_file($tmp,"image/".$gambar);

mysqli_query($conn,"
INSERT INTO produk(nama,harga,gambar,kategori)
VALUES('$nama','$harga','$gambar','$kategori')
");

header("Location: barang.php");
exit;
?>