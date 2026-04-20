<?php
session_start();
$id_user = $_SESSION['user_id'];
include 'koneksi.php';

?>

<?php
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$user = mysqli_fetch_array(mysqli_query($conn, "
    SELECT * FROM users WHERE id_users='$id_user'
"));

if (isset($_POST['update_profile'])) {
  $nama = $_POST['nama_lengkap'];
  $username = $_POST['username'];
  $email = $_POST['email'];

  mysqli_query($conn, "
    UPDATE users SET 
      nama_lengkap='$nama',
      username='$username',
      email='$email'
    WHERE id_users='$id_user'
  ");
  echo "<script>
alert('Data berhasil diubah');
window.location.href='akun.php';
</script>";
exit;
}

if (isset($_POST['update_foto'])) {
  $file = $_FILES['foto']['name'];
  $tmp  = $_FILES['foto']['tmp_name'];

  if ($file) {
    move_uploaded_file($tmp, "image/user/" . $file);

    mysqli_query($conn, "
      UPDATE users SET foto='$file'
      WHERE id_users='$id_user'
      
    ");
    
    echo "<script>
alert('Data berhasil diubah');
window.location.href='akun.php';
</script>";
exit;
  }
}

if (isset($_POST['update_password'])) {
  $lama = $_POST['password_lama'];
  $baru = $_POST['password_baru'];

  $cek = mysqli_fetch_array(mysqli_query($conn, "
    SELECT * FROM users WHERE id_users='$id_user'
  "));

  if ($lama == $cek['password']) {
    $hash = $baru;

    mysqli_query($conn, "
      UPDATE users SET password='$hash'
      WHERE id_users='$id_user'
    ");

    echo "<script>alert('Password berhasil diubah');
    window.location.href='akun.php';
</script>";
exit;
  } else {
    echo "<script>alert('Password lama salah')</script>";
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Account</title>
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

    header h4 {
      margin-top: 3px;
      margin-left: 0px;
      margin-bottom: 2px;
    }

    header {
      height: 72px;
    }

    header h4 strong {
      margin-left: 5px;
    }

    .sidebar-brand {
      margin-top: 4px;
    }

    img:hover {
  transform: scale(1.05);
  transition: 0.3s;
}

#zoomOverlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.9);
  display: none;
  justify-content: center;
  align-items: center;
  z-index: 9999;
  cursor: zoom-out;
}

#zoomOverlay img {
  max-width: 90%;
  max-height: 90%;
  transition: transform 0.2s ease;
  cursor: grab;
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
          <a href="barang.php" class=""> <span class="las la-clipboard-list"></span>
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
          <a href="" class="active"> <span class="las la-user-circle"></span>
            <span>Account</span></a>
        </li>
      </ul>
    </div>
  </div>

  <div class="main-content">
    <header>
      <h4> <label for="nav-toggle"> <span class="las la-user-circle"></span> </label><strong>Account</strong></h4>
      <div class="user-wrapper">
        <a href="akun.php">
          <img src="image/user/<?php echo $user['foto'] ?? 'default.png'; ?>"
            width="40" height="40"
            style="border-radius:50%; object-fit:cover; cursor:pointer;">
        </a>

        <div>
          <h6><?php echo $user['nama_lengkap']; ?></h6>

          <small>
            <a href="logout.php">Log Out</a>
          </small>
        </div>
      </div>
    </header>

    <main>

      <div class="card p-4">

        <h4 class="mb-4">Pengaturan Akun</h4>

        <div class="row">

          <!-- FOTO -->
          <div class="col-md-4 text-center">
            <img src="image/user/<?php echo $user['foto'] ?? 'default.png'; ?>"
     id="fotoUser"
     class="rounded-circle mb-3"
     width="150" height="150"
     style="object-fit:cover; cursor:pointer;">

            <form method="POST" enctype="multipart/form-data">
              <input type="file" name="foto" class="form-control mb-2">
              <button type="submit" name="update_foto" class="btn btn-dark btn-sm">
                Upload Foto
              </button>
            </form>
          </div>

          <!-- FORM DATA -->
          <div class="col-md-8">
            <form method="POST">

              <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control"
                  value="<?php echo $user['nama_lengkap']; ?>" required>
              </div>

              <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control"
                  value="<?php echo $user['username']; ?>" required>
              </div>

              <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                  value="<?php echo $user['email']; ?>">
              </div>

              <button type="submit" name="update_profile" class="btn btn-success">
                Simpan Perubahan
              </button>

            </form>

            <hr>

            <!-- GANTI PASSWORD -->
            <form method="POST">

              <h5>Ganti Password</h5>

              <div class="mb-2">
                <input type="password" name="password_lama" class="form-control"
                  placeholder="Password Lama" required>
              </div>

              <div class="mb-2">
                <input type="password" name="password_baru" class="form-control"
                  placeholder="Password Baru" required>
              </div>

              <button type="submit" name="update_password" class="btn btn-warning">
                Update Password
              </button>

            </form>

          </div>

        </div>

      </div>
    </main>
  </div>

  <div id="zoomOverlay">
  <img id="zoomImg">
</div>

<script>
const foto = document.getElementById("fotoUser");
const overlay = document.getElementById("zoomOverlay");
const zoomImg = document.getElementById("zoomImg");

let scale = 1;
let posX = 0;
let posY = 0;
let isDragging = false;
let startX, startY;

// klik gambar → buka
foto.onclick = function () {
  overlay.style.display = "flex";
  zoomImg.src = this.src;
  scale = 1;
  posX = 0;
  posY = 0;
  updateTransform();
};

// klik luar → close
overlay.onclick = function (e) {
  if (e.target === overlay) {
    overlay.style.display = "none";
  }
};

// zoom pakai scroll
overlay.addEventListener("wheel", function (e) {
  e.preventDefault();
  scale += e.deltaY * -0.001;

  scale = Math.min(Math.max(1, scale), 5); // min 1, max 5
  updateTransform();
});

// drag gambar
zoomImg.addEventListener("mousedown", function (e) {
  isDragging = true;
  startX = e.clientX - posX;
  startY = e.clientY - posY;
  zoomImg.style.cursor = "grabbing";
});

document.addEventListener("mousemove", function (e) {
  if (!isDragging) return;
  posX = e.clientX - startX;
  posY = e.clientY - startY;
  updateTransform();
});

document.addEventListener("mouseup", function () {
  isDragging = false;
  zoomImg.style.cursor = "grab";
});

function updateTransform() {
  zoomImg.style.transform = `translate(${posX}px, ${posY}px) scale(${scale})`;
}
</script>
<script>
window.addEventListener("pageshow", function (event) {
    if (event.persisted || window.performance.navigation.type === 2) {
        window.location.reload();
    }
});
</script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>