<?php include 'koneksi.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Produk</title>
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css">
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
  <link rel="stylesheet" href="style/main.css">
  <style>

.modal {
    display: none;
    position: fixed;
    z-index: 999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
}

.modal-content {
    background: white;
    width: 400px;
    margin: 8% auto;
    padding: 20px;
    border-radius: 15px;
    position: relative;
}

.close {
    position: absolute;
    right: 15px;
    top: 10px;
    font-size: 22px;
    cursor: pointer;
}

.form-control {
    width: 100%;
    padding: 10px;
    margin-bottom: 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
}

.btn-save {
    background: rgb(25,27,25);
    color: white;
    padding: 8px 14px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}
</style>
  <style>
    body {
      margin: 0;
      
      background: #eaebec;
    }

    .main-content {
      margin-left: 300px;
      padding: 20px;
    }
    .search-wrapper {
            border: 1px solid #ccc;
            border-radius: 25px;
            height: 40px;
            display: flex;
            align-items: center;
            overflow-x: hidden;
        }

        .search-wrapper span {
            display: inline-block;
            padding: 0rem 1rem;
            font-size: 1.5rem;
        }

        .search-wrapper input {
            height: 100%;
            padding: .5rem;
            border: none;
            outline: none;
        }

    .card {
      background: #fff;
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }

    thead {
      background: rgb(25, 27, 25);
      color: white;
    }

    thead th {
      padding: 14px;
      text-align: left;
      font-size: 15px;
    }

    tbody td {
      padding: 14px;
      border-bottom: 1px solid #ddd;
      vertical-align: middle;
    }

    tbody tr:hover {
      background: #f7f7f7;
      transition: 0.2s;
    }

    table img {
      border-radius: 10px;
      object-fit: cover;
    }

    .btn {
      border: none;
      padding: 6px 12px;
      border-radius: 8px;
      cursor: pointer;
    }

    .btn-warning {
      background: #ffc107;
      color: black;
    }

    .btn-danger {
      background: #dc3545;
      color: white;
      text-decoration: none;
    }

    .btn-dark {
      background: rgb(25, 27, 25);
      color: white;
    }
    .sidebar-menu a:hover{
    background: #ffffff88;
    color: rgb(25, 27, 25);
    border-radius: 30px 0px 0px 30px;
}

    .btn-sm {
      font-size: 13px;
    }
    .sidebar menu li a{
      text-decoration: none;
      padding-left: 0px;
    }
  </style>

  </style>
</head>

<body>

  <div class="sidebar">
    <div class="sidebar-brand">
      <h2><span class="lab la-accusoft"></span>The Cashier</h2>
    </div>
    <div class="sidebar-menu">
      <ul>
        <li>
          <a href="dashboard.php" class=""> <span class="las la-igloo"></span>
            <span>Dashboard</span></a>
        </li>
        <li>
          <a href=""> <span class="las la-users"></span>
            <span>Customer</span></a>
        </li>
        <li>
          <a href="" class="active"> <span class="las la-clipboard-list"></span>
            <span>Produk</span></a>
        </li>
        <li>
          <a href=""> <span class="las la-shopping-bag"></span>
            <span>Order</span></a>
        </li>
        <li>
          <a href=""> <span class="las la-receipt"></span>
            <span>Inventory</span></a>
        </li>
        <li>
          <a href=""> <span class="las la-user-circle"></span>
            <span>Account</span></a>
        </li>
        <li>
          <a href=""> <span class="las la-money-bill-wave"></span>
            <span>Finance</span></a>
        </li>
      </ul>
    </div>
  </div>

  <div class="main-content">
    <header>
      <h2> <label for="nav-toggle"> <span class="las la-bars"></span> </label>Data Produk</h2>
      <div class="search-wrapper"> <span class="las la-search"></span> <input type="search" placeholder="Search here" /> </div>
    </header>
    <main>
      <div class="card p-4"> <button class="btn btn-dark mb-3" onclick="openModal('tambahModal')"> Tambah Barang </button>
        <table class="table table-bordered align-middle">
          <thead class="table-dark">
            <tr>
              <th>Nama Barang</th>
              <th>Harga</th>
              <th>Kategori</th>
              <th>Gambar</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody> <?php $q = mysqli_query($conn, "SELECT * FROM produk");
                  while ($d = mysqli_fetch_array($q)) { ?>
                
                <tr>
                <td><?php echo $d['nama']; ?></td>
                <td>Rp <?php echo number_format($d['harga']); ?></td>
                <td><?php echo $d['kategori']; ?></td>
                <td> <img src="image/<?php echo $d['gambar']; ?>" width="60"> </td>
                <td> <button class="btn btn-warning btn-sm" onclick="openModal('editModal<?php echo $d['id']; ?>')">
                      Edit
                      </button>
                <div id="editModal<?php echo $d['id']; ?>" class="modal">

                <!-- Baruu -->
  <div class="modal-content">
    <span class="close" onclick="closeModal('editModal<?php echo $d['id']; ?>')">&times;</span>

    <form method="POST" enctype="multipart/form-data">

      <h3>Edit Barang</h3>

      <input type="hidden" name="id" value="<?php echo $d['id']; ?>">

      <input type="text" name="nama" class="form-control" value="<?php echo $d['nama']; ?>" required>
      <input type="number" name="harga" class="form-control" value="<?php echo $d['harga']; ?>" required>
      <input type="text" name="kategori" class="form-control" value="<?php echo $d['kategori']; ?>" required>
      <input type="file" name="gambar" class="form-control">

      <button type="submit" name="edit" class="btn-save">Update</button>

    </form>
  </div>
</div> <!-- sini-->
                <a href="hapus_barang.php?id=<?php echo $d['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus barang?')"> Hapus </a> </td>
              </tr> <?php } ?> </tbody>
        </table>
        
      </div>
    </main>
  </div>
  <!-- Modal Tambah Barang -->
<div class="modal fade" id="tambahModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <form method="POST" enctype="multipart/form-data">

        <div class="modal-header">
          <h5 class="modal-title">Tambah Barang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="text" name="nama" class="form-control mb-2" placeholder="Nama Barang" required>
          <input type="number" name="harga" class="form-control mb-2" placeholder="Harga" required>
          <input type="text" name="kategori" class="form-control mb-2" placeholder="Kategori" required>
          <input type="file" name="gambar" class="form-control" required>
        </div>

        <div class="modal-footer">
          <button type="submit" name="simpan" class="btn btn-dark">Simpan</button>
        </div>

      </form>

    </div>
  </div>
</div>

<?php
$q = mysqli_query($conn, "SELECT * FROM produk");
while($d = mysqli_fetch_array($q)){ 
?>

<!-- Modal Edit Barang -->
<div class="modal fade" id="editModal<?php echo $d['id']; ?>" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <form method="POST" enctype="multipart/form-data">

        <div class="modal-header">
          <h5 class="modal-title">Edit Barang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <input type="hidden" name="id" value="<?php echo $d['id']; ?>">

          <input type="text" name="nama" class="form-control mb-2"
            value="<?php echo $d['nama']; ?>" required>

          <input type="number" name="harga" class="form-control mb-2"
            value="<?php echo $d['harga']; ?>" required>

          <input type="text" name="kategori" class="form-control mb-2"
            value="<?php echo $d['kategori']; ?>" required>

          <input type="file" name="gambar" class="form-control">

        </div>

        <div class="modal-footer">
          <button type="submit" name="edit" class="btn btn-warning">Update</button>
        </div>

      </form>

    </div>
  </div>
</div>

<?php } ?>

<?php

if(isset($_POST['simpan'])){
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    move_uploaded_file($tmp, "image/".$gambar);

    mysqli_query($conn,"INSERT INTO produk(nama,harga,kategori,gambar)
    VALUES('$nama','$harga','$kategori','$gambar')");

    echo "<script>location='barang.php';</script>";
}

if(isset($_POST['edit'])){
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];

    if($_FILES['gambar']['name'] != ''){
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];

        move_uploaded_file($tmp, "image/".$gambar);

        mysqli_query($conn,"UPDATE produk SET
            nama='$nama',
            harga='$harga',
            kategori='$kategori',
            gambar='$gambar'
            WHERE id='$id'");
    } else {
        mysqli_query($conn,"UPDATE produk SET
            nama='$nama',
            harga='$harga',
            kategori='$kategori'
            WHERE id='$id'");
    }

    echo "<script>location='barang.php';</script>";
}
?>

<!-- Baruuuuu -->
 <div id="tambahModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal('tambahModal')">&times;</span>

    <form method="POST" enctype="multipart/form-data">

      <h3>Tambah Barang</h3>

      <input type="text" name="nama" class="form-control" placeholder="Nama Barang" required>
      <input type="number" name="harga" class="form-control" placeholder="Harga" required>
      <input type="text" name="kategori" class="form-control" placeholder="Kategori" required>
      <input type="file" name="gambar" class="form-control" required>

      <button type="submit" name="simpan" class="btn-save">Simpan</button>

    </form>
  </div>
</div>

<script>
function openModal(id){
    document.getElementById(id).style.display='block';
}

function closeModal(id){
    document.getElementById(id).style.display='none';
}

window.onclick = function(event){
    let modals = document.querySelectorAll('.modal');
    modals.forEach(function(modal){
        if(event.target == modal){
            modal.style.display='none';
        }
    });
}
</script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>