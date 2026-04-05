<?php
include 'koneksi.php';

$id = $_GET['id'];

mysqli_query($conn,"
DELETE FROM detail_transaksi
WHERE transaksi_id='$id'
");

mysqli_query($conn,"
DELETE FROM transaksi
WHERE id='$id'
");

header("Location: antrian.php");
exit;
?>