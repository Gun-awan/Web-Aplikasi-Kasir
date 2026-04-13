<?php
include 'koneksi.php';

$bulan = $_GET['bulan'];
$tahun = date('Y');

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=transaksi_bulan_$bulan.xls");

echo "<h3>Data Transaksi Bulan $bulan</h3>";

echo "<table border='1'>
<tr>
<th>Tanggal</th>
<th>Total</th>
</tr>";

$q = mysqli_query($conn, "
    SELECT DATE(tanggal) as tgl, SUM(total) as total
    FROM transaksi
    WHERE status='selesai'
    AND MONTH(tanggal) = '$bulan'
    AND YEAR(tanggal) = '$tahun'
    GROUP BY DATE(tanggal)
");

while($d = mysqli_fetch_array($q)){
    echo "<tr>
        <td>{$d['tgl']}</td>
        <td>{$d['total']}</td>
    </tr>";
}

echo "</table>";