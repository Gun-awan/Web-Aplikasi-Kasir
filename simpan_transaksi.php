<?php
include 'koneksi.php';

$customer = $_POST['customer'];
$total = $_POST['total'];
$data = json_decode($_POST['data'], true);

mysqli_query($conn,"INSERT INTO transaksi(customer,total,tanggal,status)
VALUES('$customer','$total',NOW(),'baru')") or die(mysqli_error($conn));

$id_transaksi = mysqli_insert_id($conn);

foreach($data as $item){

    $produk_id = $item['id'];
    $qty = $item['qty'];
    $subtotal = $item['harga'] * $item['qty'];

    mysqli_query($conn,"INSERT INTO detail_transaksi
    (transaksi_id, produk_id, qty, subtotal)
    VALUES
    ('$id_transaksi','$produk_id','$qty','$subtotal')")
    or die(mysqli_error($conn));
}

echo "success";
header("Location: index.php");
exit;
?>
