<?php
include 'koneksi.php';

$data = json_decode($_POST['data'], true);
$total = $_POST['total'];

mysqli_query($conn,"INSERT INTO transaksi(tanggal,total) VALUES(NOW(),'$total')");
$transaksi_id = mysqli_insert_id($conn);

foreach($data as $item){
    $id = $item['id'];
    $qty = $item['qty'];
    $subtotal = $item['harga'] * $qty;

    mysqli_query($conn,"
        INSERT INTO detail_transaksi(transaksi_id,produk_id,qty,subtotal)
        VALUES('$transaksi_id','$id','$qty','$subtotal')
    ");
}

header("Location:index.php");
?>