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
      <h2>
        <label for="nav-toggle">
          <span class="las la-bars"></span>
        </label>
        Dashboard
      </h2>
      <!-- <div class="search-wrapper">
          <span class="las la-search"></span>
          <input type="search" placeholder="Search here"/>
        </div> -->
      <div class="user-wrapper">
        <img src="img" width="40px" height="40px" alt="">
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
            <span>Customers</span>
            <h1 class="text-das"><?php echo $customer['total']; ?></h1>
          </div>
          <div>
            <span class="las la-users icon"></span>
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
        <div class="projects">
          <div class="card">
            <div class="card-header">
              <h3>Statistic</h3>
              <button>
                See All <span class="las la-arrow-right"></span>
              </button>
            </div>


            <div class="customers"></div>
            <div class="card">
              <div class="card-header">
                <h3>New Customer</h3>

                <button>See All <span class="las la-arrow-right">

                  </span></button>
              </div>


            </div>
          </div>
        </div>
    </main>
  </div>
</body>

</html>