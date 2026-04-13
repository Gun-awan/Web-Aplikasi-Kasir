<?php
include 'koneksi.php';

$tanggal = $_GET['tanggal'];

$q = mysqli_query($conn, "
    SELECT * FROM transaksi
    WHERE status='selesai'
    AND DATE(tanggal) = '$tanggal'
");
?>

<table class="table table-bordered">
    <thead>

        <tr>
            <th>Nama Customer</th>
            <th>Total Harga</th>
            <th>Bayar</th>
            <th>Kembalian</th>
        </tr>
    </thead>
    <tbody>

        <?php while($d = mysqli_fetch_array($q)) { ?>
        <tr>
            <td><?php echo $d['customer']; ?></td>
            <td>Rp <?php echo number_format($d['total']); ?></td>
            <td>Rp <?php echo number_format($d['bayar']); ?></td>
            <td>Rp <?php echo number_format($d['kembalian']); ?></td>
        </tr>
        <?php } ?>

    </tbody>
</table>

