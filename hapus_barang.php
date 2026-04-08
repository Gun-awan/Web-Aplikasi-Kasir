<?php
include 'koneksi.php';

$id = $_GET['id'];

mysqli_query($conn,"
DELETE FROM produk
WHERE id='$id'
");

echo "<script>
alert('Barang berhasil dihapus');
location='barang.php';
</script>";
?>