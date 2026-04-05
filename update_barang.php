<?php
include 'koneksi.php';

$id = $_POST['id'];
$nama = $_POST['nama'];
$harga = $_POST['harga'];
$kategori = $_POST['kategori'];

$gambar = $_FILES['gambar']['name'];
$tmp = $_FILES['gambar']['tmp_name'];

if($gambar != ''){

    move_uploaded_file($tmp,"image/".$gambar);

    mysqli_query($conn,"
    UPDATE produk
    SET nama='$nama',
        harga='$harga',
        gambar='$gambar',
        kategori='$kategori'
    WHERE id='$id'
    ");

}else{

    mysqli_query($conn,"
    UPDATE produk
    SET nama='$nama',
        harga='$harga',
        kategori='$kategori'
    WHERE id='$id'
    ");
}

header("Location: barang.php");
exit;
?>