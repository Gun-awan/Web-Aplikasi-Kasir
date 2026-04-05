<?php
include 'koneksi.php';

// Customer = total transaksi
$customer = mysqli_fetch_array(mysqli_query($conn,"
SELECT COUNT(*) as total FROM transaksi
"));

// Produk = total produk
$produk = mysqli_fetch_array(mysqli_query($conn,"
SELECT COUNT(*) as total FROM produk
"));

// Orders = antrian sekarang
$orders = mysqli_fetch_array(mysqli_query($conn,"
SELECT COUNT(*) as total FROM transaksi
WHERE status='baru'
"));

// Income = transaksi selesai
$income = mysqli_fetch_array(mysqli_query($conn,"
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
    .text-das{
        margin-top: 10px;
    }
    
* {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    list-style-type: none;
    text-decoration: none;
    font-family: 'Poppins',sans-serif;
}

.sidebar {
    overflow: hidden;
}

.sidebar-brand {
    height: 90px;
    padding: 1rem 0rem 1rem 2rem;
    color: #fff;
}

.sidebar-brand span {
    display: inline-block;
    padding-right: 1rem;
}

.sidebar-menu{
    margin-top: 1rem;
}

.sidebar-menu li {
    width: 100%;
    margin-bottom: 1.7rem;
    padding-left: 1rem;
}

.sidebar-menu a {
    padding-left: 1rem;
    display: block;
    color: #fff;
    font-size: 1.1rem;
}

.sidebar-menu a.active {
    background: #fff;
    padding-top: 1rem;
    padding-bottom: 1rem;
    color: rgb(25, 27, 25);
    border-radius: 30px 0px 0px 30px;
}

.sidebar-menu a span:first-child{
    font-size: 1.5rem;
    padding-right: 1rem;
}

.main-content {
    margin-left: 300px;
    transition: margin-left 0.4s ease;
}
header {
    background: #fffefe;
    display: flex;
    justify-content: space-between;
    padding: 1rem 1.5rem;
    box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
    position: fixed;
    left: 300px;
    width: calc(100% - 300px);
    top: 0;
    z-index: 100;
    transition: left 0.4s ease, width 0.4s ease;
}

header h2 {
    color: #222;
}

header label span {
    font-size: 1.7rem;
    padding-right: 1rem;
}

.search-wrapper {
    border: 1px solid #ccc;
    border-radius: 30px;
    height: 50px;
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

.user-wrapper {
    display: flex;
    align-items: center;
}

.user-wrapper img {
    border-radius: 50%;
    margin-right: 1rem;
}

.user-wrapper small{
    display: inline-block;
    color: grey;
}

main {
    margin-top: 60px;
    padding: 2rem 1.5rem;
    background: #eaebec;
    min-height: calc(100vh - 90px);
}

.cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-gap: 2rem;
    margin-top: 1rem;
    
}

.card-singel {
    display: flex;
    font-size: 11px;
    justify-content: space-between;
    background: #fff;
    padding: 1.5rem;
    border-radius: 20px;
    box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
}

.card-singel div:last-child span {
    font-size: 2rem;
    color: rgb(25, 27, 25);
}

.card-singel div:first-child span {
    color: grey;
}

.card-singel {
    background: rgb(25, 27, 25);
    color: white;
}

.card-singel h1,
.card-singel span,
.card-singel .las,
.card-singel .lab {
    color: white !important;
}

.recent-grid {
    margin-top: 2rem;
    display: grid;
    grid-gap: 2rem;
    grid-template-columns: 100% auto;
}

.card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
}

.card-header,
.card-body {
    padding: 1rem;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-header button {
    background: rgb(25, 27, 25);
    border-radius: 10px;
    color: #fff;
    font-size: .8rem;
    padding: .5rem 1rem;
}

table{
    border-collapse: collapse;
}
.card-produk{
  background: rgb(25, 27, 25);
    color: white;
}
#nav-toggle {
    display: none;
}
#nav-toggle:checked + .sidebar {
    width: 70px;
}
#nav-toggle:checked + .sidebar .sidebar-brand,
#nav-toggle:checked + .sidebar li {
    padding-left: 1rem;
    text-align: center;
}
#nav-toggle:checked + .sidebar li a span:last-child {
    display: none;
}
#nav-toggle:checked ~ .main-content {
    margin-left: 70px;
}
#nav-toggle:checked ~ .main-content header {
    left: 70px;
    width: calc(100% - 70px);
}
#nav-toggle:checked + .sidebar li a {
    padding-left: 0;
}
#nav-toggle:checked + .sidebar .brand-text {
    display: none;
}

    
  </style>
</head>
<body>
<input type="checkbox" id="nav-toggle">
  <div class="sidebar">
    <div class="sidebar-brand">
      <h2>
        <span class="lab la-accusoft"></span>
        <span class="brand-text">The Cashier</span>
    </h2>
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
            <span>Orders</span></a>
        </li>
        <li>
          <a href=""> <span class="las la-receipt"></span>
            <span>Inventory</span></a>
        </li>
        <li>
          <a href="index.php"> <span class="las la-money-bill-wave"></span>
            <span>Transaksi</span></a>
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
          
  
</body>
</html>