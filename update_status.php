<?php
include 'koneksi.php';

$id = $_REQUEST['id'];
$status = $_REQUEST['status'];

$bayar = isset($_REQUEST['bayar']) ? $_REQUEST['bayar'] : 0;
$kembalian = isset($_REQUEST['kembalian']) ? $_REQUEST['kembalian'] : 0;

if($status == 'selesai'){

    mysqli_query($conn,"
    UPDATE transaksi SET
    status='$status',
    bayar='$bayar',
    kembalian='$kembalian'
    WHERE id='$id'
    ");

}else{

    mysqli_query($conn,"
    UPDATE transaksi SET
    status='$status'
    WHERE id='$id'
    ");

}

header("location:antrian.php");
?>