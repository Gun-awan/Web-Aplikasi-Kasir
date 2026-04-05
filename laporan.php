<?php include 'koneksi.php'; ?>

<?php

// HARIAN
$harian = mysqli_fetch_array(mysqli_query($conn,"
SELECT 
COUNT(*) as jumlah,
SUM(total) as omzet
FROM transaksi
WHERE DATE(tanggal)=CURDATE()
"));

// BULANAN
$bulanan = mysqli_fetch_array(mysqli_query($conn,"
SELECT 
COUNT(*) as jumlah,
SUM(total) as omzet
FROM transaksi
WHERE MONTH(tanggal)=MONTH(CURDATE())
AND YEAR(tanggal)=YEAR(CURDATE())
"));

?>