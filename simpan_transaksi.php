<?php
include 'koneksi.php';

$customer = $_POST['customer'];
$total = $_POST['total'];
$data = json_decode($_POST['data'], true);

if(isset($_POST['edit_id'])){

    $id = $_POST['edit_id'];

    // UPDATE transaksi
    mysqli_query($conn, "
        UPDATE transaksi 
        SET customer='$customer', total='$total'
        WHERE id='$id'
    ") or die(mysqli_error($conn));

    // HAPUS detail lama
    mysqli_query($conn, "
        DELETE FROM detail_transaksi 
        WHERE transaksi_id='$id'
    ") or die(mysqli_error($conn));

    // INSERT ulang detail
    foreach($data as $item){

        $produk_id = $item['id'];
        $qty = $item['qty'];
        $subtotal = $item['harga'] * $item['qty'];

        mysqli_query($conn, "
            INSERT INTO detail_transaksi
            (transaksi_id, produk_id, qty, subtotal)
            VALUES
            ('$id','$produk_id','$qty','$subtotal')
        ") or die(mysqli_error($conn));
    }

} else {

    // INSERT transaksi baru
    mysqli_query($conn,"
        INSERT INTO transaksi(customer,total,tanggal,status)
        VALUES('$customer','$total',NOW(),'baru')
    ") or die(mysqli_error($conn));

    $id_transaksi = mysqli_insert_id($conn);

    foreach($data as $item){

        $produk_id = $item['id'];
        $qty = $item['qty'];
        $subtotal = $item['harga'] * $item['qty'];

        mysqli_query($conn,"
            INSERT INTO detail_transaksi
            (transaksi_id, produk_id, qty, subtotal)
            VALUES
            ('$id_transaksi','$produk_id','$qty','$subtotal')
        ") or die(mysqli_error($conn));
    }
}

echo "success";
header("Location: index.php");
exit;
?>