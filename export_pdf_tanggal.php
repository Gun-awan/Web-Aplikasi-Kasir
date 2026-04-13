<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;

include 'koneksi.php';

$tanggal = $_GET['tanggal'];

$html = "<h3>Data Transaksi $tanggal</h3>";
$html .= "<table border='1' width='100%' cellspacing='0' cellpadding='5'>
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
    $html .= "<tr>
        <td>{$d['customer']}</td>
        <td>{$d['total']}</td>
        <td>{$d['bayar']}</td>
        <td>{$d['kembalian']}</td>
    </tr>";
}

$html .= "</table>";

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->stream("transaksi_$tanggal.pdf");