<?php
include 'koneksi.php';

$id = $_GET['id'];

mysqli_query($conn,"UPDATE transaksi SET status='pending' WHERE id='$id'");

header("Location: antrian.php");
?>