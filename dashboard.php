<?php
include 'koneksi.php';

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css" >
  <link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" >
  <link rel="stylesheet" href="style/main.css">
  <style>
    .text-das {
      margin-top: 10px;
    }
    .sidebar-menu a:hover{
    background: #ffffff88;
    color: rgb(25, 27, 25);
    border-radius: 30px 0px 0px 30px;
}
.stats-grid{
    display:grid;
    grid-template-columns: repeat(3, 1fr);
    gap:20px;
}

.stat-card{
    border-radius:15px;
    box-shadow:0 4px 12px rgba(0,0,0,0.12);
    padding:10px;
    padding-bottom: 2px;
    background:white;
}
.pendapatan{
    border-radius:15px;
    box-shadow:0 4px 12px rgba(0,0,0,0.12);
    padding-left:px;
    padding-bottom: 2px;
    background:rgb(25, 27, 25);
    color: white;
}

.card-body h2{
  margin-top: 2px;
    font-size:24px;
    margin:0px;
    color:rgb(8, 8, 8);
}
.card-body h3{
    margin:0px;
    color:rgb(241, 241, 241);
}

.card-body small{
    color:gray;
}
.card-header h3{
  font-family: 'Poppins', sans-serif;
}
.judul{
    height: 72px;
}
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
          <a href="" class="active"> <span class="las la-igloo"></span>
            <span>Dashboard</span></a>
        </li>
        <li>
          <a href=""> <span class="las la-users"></span>
            <span>Customer</span></a>
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
          <a href=""> <span class="las la-receipt"></span>
            <span>Cashier</span></a>
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
    <header class="judul">
      <h2>
        <label for="nav-toggle">
          <span class="las la-igloo"></span>
        </label>
        Dashboard
      </h2>
      <!-- <div class="search-wrapper">
          <span class="las la-search"></span>
          <input type="search" placeholder="Search here"/>
        </div> -->
      <div class="user-wrapper">
        <img src="" width="40px" height="40px" alt="">
        <div>
          <h4>Admin</h4>
          <small>Admin</small>
        </div>
      </div>
    </header>

    <main>
      <div class="cards">
        <div class="card-singel">
          <div>
            <span>Favourite Toping</span>
            <h1 class="text-das"><?php echo $customer['total']; ?></h1>
          </div>
          <div>
            <span class="lar la-heart icon"></span>
          </div>
        </div>
        <div class="card-singel card-produk">
          <div>
            <span>Produk</span>
            <h1 class="text-das"><?php echo $produk['total']; ?></h1>
          </div>
          <div>
            <span class="las la-clipboard-list icon"></span>
          </div>
        </div>
        <div class="card-singel">
          <div>
            <span>Orders</span>
            <h1 class="text-das"><?php echo $orders['total']; ?></h1>
          </div>
          <div>
            <span class="las la-shopping-bag icon"></span>
          </div>
        </div>
        <div class="card-singel">
          <div>
            <span>Income</span>
            <h1 class="text-das">Rp <?php echo number_format($income['total'] ?? 0); ?></h1>
          </div>
          <div>
            <span class="lab la-google-wallet icon"></span>
          </div>
        </div>
      </div>
      <div class="recent-grid">

    <div class="stats-grid">

        <div class="card stat-card">
            <div class="card-header">
                <h3>Transaksi Hari Ini</h3>
                <p>2-Mar-2026</p>
            </div>
            <div class="card-body">
                <h2>25</h2>
                <small>Total transaksi hari ini</small>
            </div>
        </div>

        <div class="card stat-card">
            <div class="card-header">
                <h3>Transaksi Minggu Ini</h3>
            </div>
            <div class="card-body">
                <h2>120</h2>
                <small>Total transaksi minggu ini</small>
            </div>
        </div>

        <div class="card stat-card">
            <div class="card-header">
                <h3>Transaksi Bulan Ini</h3>
                <p>Maret</p>
            </div>
            <div class="card-body">
                <h2>480</h2>
                <small>Total transaksi bulan ini</small>
            </div>
        </div>

    </div>

</div>
<div class="recent-grid">

    <div class="stats-grid">

        <div class="card stat-card pendapatan">
            <div class="card-header">
                <h5>Pendapatan Hari Ini</h5>
                <p>2-Mar-2026</p>
            </div>
            <div class="card-body">
                <h3>Rp 1.000.000</h3>
            </div>
        </div>

        <div class="card stat-card pendapatan">
            <div class="card-header">
                <h5>Pendapatan Minggu Ini</h5>
            </div>
            <div class="card-body">
                <h3>Rp 1.000.000</h3>
            </div>
        </div>

        <div class="card stat-card pendapatan">
            <div class="card-header">
                <h5>Pendapatan Bulan Ini</h5>
                <p>Maret</p>
            </div>
            <div class="card-body">
                <h3>Rp 1.000.000</h3>
            </div>
        </div>

    </div>

</div>
    </main>
  </div>
</body>

</html>