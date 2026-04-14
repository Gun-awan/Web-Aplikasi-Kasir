<?php include 'koneksi.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Produk</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css">
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
  <link rel="stylesheet" href="style/main.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>

    .modal-content {
      background: white;

      padding: 20px;
      border-radius: 15px;
      position: relative;
    }
    .modal.fade .modal-dialog {
    transform: scale(0.9);
    transition: 0.3s ease;
}

.modal.show .modal-dialog {
    transform: scale(1);
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
      background: rgb(25, 27, 25);
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
      overflow-x: hidden;
      margin-right: 50px;
    }

    .search-wrapper span {
      display: inline-block;
      padding: 0rem 1rem;
      font-size: 1.5rem;
    }

    .search-wrapper input {
      height: 100%;
      padding: 5px;
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

    .btn-warning:hover {
      background: #f7d570;
      color: black;
    }

    .btn-danger:hover {
      background: #f0717d;
      color: white;
      text-decoration: none;
    }

    .btn-danger {
      background: #dc3545;
      color: white;
      text-decoration: none;
    }

    .btn-dark {
      background: rgb(25, 27, 25);
      color: white;
      width: 180px;
      height: 40px;
    }

    .btn-dark:hover {
      background: rgb(96, 99, 96);
      color: white;
    }

    .sidebar-menu a:hover {
      background: #ffffff88;
      color: rgb(25, 27, 25);
      border-radius: 30px 0px 0px 30px;
    }

    .btn-sm {
      font-size: 13px;
    }
    .sidebar-menu li a {
  text-decoration: none !important;
  padding-right: 90px !important;
}
    header h4{
      margin-top: 3px;
      margin-left: 0px;
      margin-bottom: 2px;
    }
    header{
      height: 72px;
    }
    header h4 strong{
      margin-left: 5px;
    }
    .sidebar-brand{
      margin-top: 4px;
    }
  </style>
</head>

<body>

  <div class="sidebar">
    <div class="sidebar-brand">
      <h4><strong><span class="lab la-accusoft"></span>The Cashier</strong></h4>
    </div>
    <div class="sidebar-menu">
      <ul>
        <li>
          <a href="dashboard.php" class=""> <span class="las la-igloo"></span>
            <span>Dashboard</span></a>
        </li>
        <li>
          <a href="" class="active"> <span class="las la-clipboard-list"></span>
            <span>Produk</span></a>
        </li>
        <li>
          <a href="antrian.php"> <span class="las la-shopping-bag"></span>
            <span>Order</span></a>
        </li>
        <li>
          <a href="index.php"> <span class="las la-receipt"></span>
            <span>Cashier</span></a>
        </li>
        <li>
          <a href="transaksi.php"> <span class="las la-coins"></span>
            <span>Transaksi</span></a>
        </li>
        <li>
          <a href="finance.php"> <span class="las la-money-bill-wave"></span>
            <span>Income</span></a>
        </li>
        <li>
          <a href=""> <span class="las la-user-circle"></span>
            <span>Account</span></a>
        </li>
      </ul>
    </div>
  </div>

  <div class="main-content">
    <header>
      <h4> <label for="nav-toggle"> <span class="las la-clipboard-list"></span> </label><strong>Data Produk</strong></h4>
      <div class="search-wrapper"> <span class="las la-search"></span> <input type="text" id="searchProduk" placeholder="Search here" onkeyup="searchProduk()"> </div>
      <div class="user-wrapper">
        <img src="" width="40px" height="40px" alt="">
        <div>
          <h6>Admin</h6>
          <small>Admin</small>
        </div>
      </div>
    </header>
    <main>
      <div class="card p-4">
        <div class="d-flex justify-content-between">
        <button class="btn btn-dark mb-1"
          data-bs-toggle="modal"
          data-bs-target="#tambahModal">
          <strong>Tambah Barang</strong>
        </button>
        <button class="btn btn-dark mb-1"
          data-bs-toggle="modal"
          data-bs-target="#tambahModal">
          <strong>kategori</strong>
        </button>
        </div>
        <table class="table table-bordered align-middle">
          <thead class="table-dark">
            <tr>
              <th>No.</th>
              <th>Nama Barang</th>
              <th>Harga</th>
              <th>Kategori</th>
              <th>Gambar</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody> <?php $q = mysqli_query($conn, "
SELECT produk.*, kategori.kategori
FROM produk
JOIN kategori ON produk.id_kategori = kategori.id_kategori
");
                  $no = 1;
                  while ($d = mysqli_fetch_array($q)) { ?>

              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $d['nama']; ?></td>
                <td>Rp <?php echo number_format($d['harga']); ?></td>
                <td><?php echo $d['kategori']; ?></td>
                <td> <img src="image/<?php echo $d['gambar']; ?>" width="60"> </td>
                <td> <button class="btn btn-warning btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#editModal<?php echo $d['id']; ?>">
                    Edit
                  </button>

                    <!-- Baruu -->
                    <div class="modal fade" id="editModal<?php echo $d['id']; ?>" tabindex="-1">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-4 shadow">

                          <form method="POST" enctype="multipart/form-data">

                            <div class="modal-header border-0">
                              <h5 class="modal-title">Edit Barang</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                              <input type="hidden" name="id" value="<?php echo $d['id']; ?>">

                              <input type="text" name="nama" class="form-control mb-3"
                                value="<?php echo $d['nama']; ?>" required>

                              <input type="number" name="harga" class="form-control mb-3"
                                value="<?php echo $d['harga']; ?>" required>

                              <select name="id_kategori" class="form-control mb-3" required>

                                <?php
                                $kategori = mysqli_query($conn, "SELECT * FROM kategori");
                                while ($k = mysqli_fetch_array($kategori)) {
                                ?>

                                  <option value="<?php echo $k['id_kategori']; ?>"
                                    <?php if ($d['id_kategori'] == $k['id_kategori']) echo 'selected'; ?>>

                                    <?php echo $k['kategori']; ?>

                                  </option>

                                <?php } ?>

                              </select>

                              <input type="file" name="gambar" class="form-control">

                            </div>

                            <div class="modal-footer border-0">
                              <button type="submit" name="edit" class="btn btn-warning">Update</button>
                            </div>

                          </form>

                        </div>
                      </div>
                    </div>
                    <a href="hapus_barang.php?id=<?php echo $d['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus barang?')"> Hapus </a>
                </td>
              </tr> <?php } ?>
          </tbody>
        </table>

      </div>
    </main>
  </div>

  <?php

  if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $id_kategori = $_POST['id_kategori'];

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    move_uploaded_file($tmp, "image/" . $gambar);

    mysqli_query($conn, "INSERT INTO produk(nama,harga,id_kategori,gambar)
    VALUES('$nama','$harga','$id_kategori','$gambar')");

    echo "<script>
alert('Barang berhasil ditambahkan');
location='barang.php';
</script>";
  }

  if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $id_kategori = $_POST['id_kategori'];

    if ($_FILES['gambar']['name'] != '') {
      $gambar = $_FILES['gambar']['name'];
      $tmp = $_FILES['gambar']['tmp_name'];

      move_uploaded_file($tmp, "image/" . $gambar);

      mysqli_query($conn, "UPDATE produk SET
            nama='$nama',
            harga='$harga',
            id_kategori='$id_kategori',
            gambar='$gambar'
            WHERE id='$id'");
    } else {
      mysqli_query($conn, "UPDATE produk SET
            nama='$nama',
            harga='$harga',
            id_kategori='$id_kategori'
            WHERE id='$id'");
    }

    echo "<script>
alert('Barang berhasil diupdate');
location='barang.php';
</script>";
  }
  ?>

  <!-- Baruuuuu -->
  <div class="modal fade" id="tambahModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4 shadow">

        <form method="POST" enctype="multipart/form-data">

          <div class="modal-header border-0">
            <h5 class="modal-title">Tambah Barang</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">

            <input type="text" name="nama" class="form-control mb-3" placeholder="Nama Barang" required>

            <input type="number" name="harga" class="form-control mb-3" placeholder="Harga" required>

            <select name="id_kategori" class="form-control mb-3" required>
              <option value="">Pilih Kategori</option>

              <?php
              $kategori = mysqli_query($conn, "SELECT * FROM kategori");
              while ($k = mysqli_fetch_array($kategori)) {
              ?>
                <option value="<?php echo $k['id_kategori']; ?>">
                  <?php echo $k['kategori']; ?>
                </option>
              <?php } ?>
            </select>

            <input type="file" name="gambar" class="form-control" required>

          </div>

          <div class="modal-footer border-0">
            <button type="submit" name="simpan" class="btn btn-dark">Simpan</button>
          </div>

        </form>

      </div>
    </div>
  </div>

  <script>
    function searchProduk() {
      let input = document.getElementById("searchProduk").value.toLowerCase();
      let rows = document.querySelectorAll("tbody tr");

      rows.forEach(function(row) {
        let nama = row.cells[1].innerText.toLowerCase();
        let kategori = row.cells[2].innerText.toLowerCase();

        if (nama.includes(input) || kategori.includes(input)) {
          row.style.display = "";
        } else {
          row.style.display = "none";
        }
      });
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>