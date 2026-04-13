<?php
include 'koneksi.php';

$tanggal = $_GET['tanggal'];

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=transaksi_$tanggal.xls");

echo "<h3>Data Transaksi Tanggal $tanggal</h3>";

echo "<table border='1'>
<tr>
<th>Customer</th>
<th>Total</th>
<th>Bayar</th>
<th>Kembalian</th>
</tr>";

$q = mysqli_query($conn, "
    SELECT * FROM transaksi
    WHERE status='selesai'
    AND DATE(tanggal) = '$tanggal'
");

while($d = mysqli_fetch_array($q)){
    echo "<tr>
        <td>{$d['customer']}</td>
        <td>{$d['total']}</td>
        <td>{$d['bayar']}</td>
        <td>{$d['kembalian']}</td>
    </tr>";
}

echo "</table>";