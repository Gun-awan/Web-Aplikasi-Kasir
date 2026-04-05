<?php
include 'koneksi.php';

$id = $_GET['id'];
$d = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM produk WHERE id='$id'"));
?>

<form action="update_barang.php" method="POST" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?php echo $d['id']; ?>">

Nama:
<input type="text" name="nama" value="<?php echo $d['nama']; ?>"><br>

Harga:
<input type="number" name="harga" value="<?php echo $d['harga']; ?>"><br>

Gambar Lama:<br>
<img src="image/<?php echo $d['gambar']; ?>" width="100"><br>

Ganti Gambar:
<input type="file" name="gambar"><br>

Kategori:
<input type="text" name="kategori" value="<?php echo $d['kategori']; ?>"><br>

<button>Simpan</button>

</form>