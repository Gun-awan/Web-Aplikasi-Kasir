<?php
require 'vendor/autoload.php'; // ✅ ini yang benar

use Dompdf\Dompdf;

include 'koneksi.php';

$bulan = $_GET['bulan'];
$tahun = date('Y');

$nama_bulan = [
  1=>'Januari','Februari','Maret','April','Mei','Juni',
  'Juli','Agustus','September','Oktober','November','Desember'
];

$html = "<h3>Data Bulan ".$nama_bulan[(int)$bulan]."</h3>";
$html .= "<table border='1' width='100%' cellspacing='0' cellpadding='5'>
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
    $html .= "<tr>
        <td>{$d['tgl']}</td>
        <td>Rp ".number_format($d['total'])."</td>
    </tr>";
}

$html .= "</table>";

$dompdf = new Dompdf(); // ✅ sekarang tidak error
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("bulan_$bulan.pdf", ["Attachment" => false]);
?>