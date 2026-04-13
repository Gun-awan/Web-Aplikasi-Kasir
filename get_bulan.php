<?php
include 'koneksi.php';

$bulan = $_GET['bulan'];
$tahun = date('Y');

// hitung jumlah hari di bulan
$jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

echo '
<table class="table table-bordered">
<thead>
<tr>
<th>Tanggal</th>
<th>Penghasilan</th>
</tr>
</thead>
<tbody>
';

for ($i = 1; $i <= $jumlah_hari; $i++) {

    $tgl = $tahun . '-' . $bulan . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);

    $q = mysqli_query($conn, "
        SELECT SUM(total) as income
        FROM transaksi
        WHERE status='selesai'
        AND DATE(tanggal) = '$tgl'
    ");

    $d = mysqli_fetch_array($q);
    $income = $d['income'] ? $d['income'] : 0;

    echo "<tr>
    <td>
        <a href='#' class='openTanggal' data-tanggal='$tgl'>
            ".date('d M Y', strtotime($tgl))."
        </a>
    </td>
    <td>Rp ".number_format($income)."</td>
</tr>";
}

echo "</tbody></table>";
?>