<?php
include 'koneksi.php';

$id = $_POST['id'];
$status = $_POST['status'];

mysqli_query($conn,"
UPDATE transaksi
SET status='$status'
WHERE id='$id'
");