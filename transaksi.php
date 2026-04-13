<?php
include 'koneksi.php';

$today = date('Y-m-d');

$transaksi_hari_ini = mysqli_fetch_array(mysqli_query($conn, "
    SELECT COUNT(*) as total 
    FROM transaksi 
    WHERE status='selesai' 
    AND DATE(tanggal) = '$today'
"));

$pendapatan_hari_ini = mysqli_fetch_array(mysqli_query($conn, "
    SELECT SUM(total) as total 
    FROM transaksi 
    WHERE status='selesai' 
    AND DATE(tanggal) = '$today'
"));

$transaksi_minggu = mysqli_fetch_array(mysqli_query($conn, "
    SELECT COUNT(*) as total 
    FROM transaksi 
    WHERE status='selesai'
    AND YEARWEEK(tanggal, 1) = YEARWEEK(CURDATE(), 1)
"));

$pendapatan_minggu = mysqli_fetch_array(mysqli_query($conn, "
    SELECT SUM(total) as total 
    FROM transaksi 
    WHERE status='selesai'
    AND YEARWEEK(tanggal, 1) = YEARWEEK(CURDATE(), 1)
"));

$transaksi_bulan = mysqli_fetch_array(mysqli_query($conn, "
    SELECT COUNT(*) as total 
    FROM transaksi 
    WHERE status='selesai'
    AND MONTH(tanggal) = MONTH(CURDATE())
    AND YEAR(tanggal) = YEAR(CURDATE())
"));

$pendapatan_bulan = mysqli_fetch_array(mysqli_query($conn, "
    SELECT SUM(total) as total 
    FROM transaksi 
    WHERE status='selesai'
    AND MONTH(tanggal) = MONTH(CURDATE())
    AND YEAR(tanggal) = YEAR(CURDATE())
"));

// Customer = total transaksi
$customer = mysqli_fetch_array(mysqli_query($conn, "
SELECT COUNT(*) as total FROM transaksi
"));

// Produk = total produk
$produk = mysqli_fetch_array(mysqli_query($conn, "
SELECT COUNT(*) as total FROM produk
"));

// Orders = antrian sekarang
$orders = mysqli_fetch_array(mysqli_query($conn, "
SELECT COUNT(*) as total FROM transaksi
WHERE status='baru'
"));

// Income = transaksi selesai
$income = mysqli_fetch_array(mysqli_query($conn, "
SELECT SUM(total) as total FROM transaksi
WHERE status='selesai'
"));

$fav = mysqli_query($conn, "
SELECT produk.nama, SUM(detail_transaksi.qty) as total_pesan
FROM detail_transaksi
JOIN produk ON detail_transaksi.produk_id = produk.id
GROUP BY detail_transaksi.produk_id
ORDER BY total_pesan DESC
LIMIT 1
");

$fav_menu = mysqli_fetch_array($fav);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transaksi</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css">
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
  <link rel="stylesheet" href="style/main.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .text-das {
      margin-top: 10px;
    }

    .sidebar-menu a:hover {
      background: #ffffff88;
      color: rgb(25, 27, 25);
      border-radius: 30px 0px 0px 30px;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
    }

    .stat-card {
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
      padding: 10px;
      padding-bottom: 2px;
      background: white;
    }

    .pendapatan {
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
      padding-left: px;
      padding-bottom: 2px;
      background: rgb(25, 27, 25);
      color: white;
    }

    .card-singel {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    .card-body h2 {
      margin-top: 2px;
      font-size: 24px;
      margin: 0px;
      color: rgb(8, 8, 8);
    }

    .card-body h3 {
      margin: 0px;
      color: rgb(241, 241, 241);
    }

    .card-body small {
      color: gray;
    }

    .card-header h3 {
      font-family: 'Poppins', sans-serif;
    }

    .judul {
      height: 72px;
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
          <a href="dashboard.php"> <span class="las la-igloo"></span>
            <span>Dashboard</span></a>
        </li>
        <li>
          <a href="barang.php"> <span class="las la-clipboard-list"></span>
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
          <a href="" class="active"> <span class="las la-receipt"></span>
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
        </li>
      </ul>
    </div>
  </div>

  <div class="main-content">
    <header class="judul">
      <h4>
        <label for="nav-toggle">
          <span class="las la-receipt"></span>
        </label><strong>
        Transaksi</strong>
      </h4>
      <!-- <div class="search-wrapper">
          <span class="las la-search"></span>
          <input type="search" placeholder="Search here"/>
        </div> -->
      <div class="user-wrapper">
        <img src="" width="40px" height="40px" alt="">
        <div>
          <h6>Admin</h6>
          <small>Admin</small>
        </div>
      </div>
    </header>

    <main>
      
      <div class="recent-grid">

        <div class="stats-grid">

          <div class="card stat-card">
            <div class="card-header">
              <h6>Transaksi Hari Ini</h6>
              <p><?php echo date('d-M-Y'); ?></p>
            </div>
            <div class="card-body">
              <h2><?php echo $transaksi_hari_ini['total']; ?></h2>
              <small>Total transaksi hari ini</small>
            </div>
          </div>

          <div class="card stat-card">
            <div class="card-header">
              <h6>Transaksi Minggu Ini</h6>
              <p><?php echo date('W'); ?></p>
            </div>
            <div class="card-body">
              <h2><?php echo $transaksi_minggu['total']; ?></h2>
              <small>Total transaksi minggu ini</small>
            </div>
        </div>

        <div class="card stat-card">
          <div class="card-header">
            <h6>Transaksi Bulan Ini</h6>
            <p><?php echo date('F'); ?></p>
          </div>
          <div class="card-body">
            <h2><?php echo $transaksi_bulan['total']; ?></h2>
            <small>Total transaksi bulan ini</small>
          </div>
        </div>

      </div>

  </div>
  <div class="recent-grid">

    <div class="stats-grid">

      <div class="card stat-card pendapatan">
        <div class="card-header">
          <h6>Pendapatan Hari Ini</h6>
          <p><?php echo date('d-M-Y'); ?></p>
        </div>
        <div class="card-body">
          <h4>Rp <?php echo number_format($pendapatan_hari_ini['total'] ?? 0); ?></h4>
        </div>
      </div>

      <div class="card stat-card pendapatan">
        <div class="card-header">
          <h6>Pendapatan Minggu Ini</h6>
          <p><?php echo date('W'); ?></p>
        </div>
        <div class="card-body">
          <h4>Rp <?php echo number_format($pendapatan_minggu['total'] ?? 0); ?></h4>
        </div>
      </div>

      <div class="card stat-card pendapatan">
        <div class="card-header">
          <h6>Pendapatan Bulan Ini</h6>
          <p><?php echo date('F'); ?></p>
        </div>
        <div class="card-body">
          <h4>Rp <?php echo number_format ($pendapatan_bulan['total'] ?? 0); ?></h4>
        </div>
      </div>

    </div>

  </div>
  </main>
  </div>
</body>

</html>