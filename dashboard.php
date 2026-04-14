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

// Produk terjual
$produkjual = mysqli_fetch_array(mysqli_query($conn, "
SELECT SUM(qty) as total FROM detail_transaksi
WHERE DATE(tgl_transaksi) = '$today'
"));

// Orders = antrian sekarang
$orders = mysqli_fetch_array(mysqli_query($conn, "
SELECT COUNT(*) as total FROM transaksi
WHERE status='selesai'
AND DATE(tanggal) = '$today'
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

<?php
$labels = [];
$data = [];

$bulan = date('m');
$tahun = date('Y');

$qChart = mysqli_query($conn, "
    SELECT DATE(tanggal) as tgl, SUM(total) as total
    FROM transaksi
    WHERE status='selesai'
    AND MONTH(tanggal) = '$bulan'
    AND YEAR(tanggal) = '$tahun'
    GROUP BY DATE(tanggal)
    ORDER BY tgl ASC
");

while($d = mysqli_fetch_array($qChart)){
    $labels[] = date('d', strtotime($d['tgl']));
    $data[] = $d['total'];
}
?>

<?php
$labels_transaksi = [];
$data_transaksi = [];

$bulan = date('m');
$tahun = date('Y');

$qTrans = mysqli_query($conn, "
    SELECT DATE(tanggal) as tgl, COUNT(*) as jumlah
    FROM transaksi
    WHERE status='selesai'
    AND MONTH(tanggal) = '$bulan'
    AND YEAR(tanggal) = '$tahun'
    GROUP BY DATE(tanggal)
    ORDER BY tgl ASC
");

while($d = mysqli_fetch_array($qTrans)){
    $labels_transaksi[] = date('d', strtotime($d['tgl']));
    $data_transaksi[] = $d['jumlah'];
}
?>

<?php
$label_produk = [];
$data_produk = [];

$qProduk = mysqli_query($conn, "
    SELECT p.nama, SUM(dt.qty) as total_terjual
    FROM detail_transaksi dt
    JOIN produk p ON dt.produk_id = p.id
    JOIN transaksi t ON dt.transaksi_id = t.id
    WHERE t.status='selesai' AND DATE(tanggal) = '$today'
    GROUP BY dt.produk_id
    ORDER BY total_terjual DESC
");
if(!$qProduk){
    die("Query Error: " . mysqli_error($conn));
}

while($d = mysqli_fetch_array($qProduk)){
    $label_produk[] = $d['nama'];
    $data_produk[] = $d['total_terjual'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css">
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
  <link rel="stylesheet" href="style/main.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    .card{
      margin-top: 20px;
    }
    .cards{
      margin-top: 2px;
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
          <a href="" class="active"> <span class="las la-igloo"></span>
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
    <header class="judul">
      <h4>
        <label for="nav-toggle">
          <span class="las la-igloo"></span>
        </label><strong>
        Dashboard</strong>
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
      <div class="cards">
        <div class="card-singel">
          <div>
            <span>Favourite Menu</span>
            <h6 class="text-das"><?php echo $fav_menu['nama'] ?? 0; ?></h6>
          </div>
          <div>
            <span class="lar la-heart icon"></span>
          </div>
        </div>
        <div class="card-singel">
          <div>
            <span>All Produk</span>
            <h5 class="text-das"><?php echo $produk['total']; ?></h5>
          </div>
          <div>
            <span class="las la-clipboard-list icon"></span>
          </div>
        </div>
        <div class="card-singel">
          <div>
            <span>Orders Today</span>
            <h5 class="text-das"><?php echo $orders['total']; ?></h5>
          </div>
          <div>
            <span class="las la-shopping-bag icon"></span>
          </div>
        </div>
        <div class="card-singel">
          <div>
            <span>Income Today</span>
            <h5 class="text-das text-white">Rp <?php echo number_format($pendapatan_hari_ini['total'] ?? 0); ?></h5>
          </div>
          <div>
            <span class="lab la-google-wallet icon"></span>
          </div>
        </div>
      </div>

      <div class="card shadow rounded-4 p-3 mt-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h5>Produk Terlaris Hari Ini</h5>
        <!-- <small>Top 5</small> -->
    </div>

    <canvas id="chartProduk" height="120"></canvas>
</div>

      <div class="card shadow rounded-4 p-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h5>Grafik Pendapatan Bulan Ini</h5>
        <small><?php echo date('F Y'); ?></small>
    </div>

    <canvas id="chartPendapatan" height="100"></canvas>
</div>

<div class="card shadow rounded-4 p-3 mt-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h5>Grafik Transaksi Bulan Ini</h5>
        <small><?php echo date('F Y'); ?></small>
    </div>

    <canvas id="chartTransaksi" height="100"></canvas>
</div>

  </div>
  <script>
    
const ctx = document.getElementById('chartPendapatan');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: <?php echo json_encode($data); ?>,
            borderWidth: 3,
            tension: 0.4,
            fill: true,
            backgroundColor: 'rgba(25, 135, 84, 0.1)', // hijau soft
            borderColor: '#198754',
            pointBackgroundColor: '#198754'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true
            }
        },
        
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value){
                        return 'Rp ' + value.toLocaleString();
                    }
                }
            }
        },
        interaction: {
    mode: 'index',
    intersect: false
}
    }
});
</script>

<script>
const ctx3 = document.getElementById('chartProduk');

new Chart(ctx3, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($label_produk); ?>,
        datasets: [{
            label: 'Jumlah Terjual',
            data: <?php echo json_encode($data_produk); ?>,
            borderWidth: 1,
            backgroundColor: [
                '#0d6efd',
                '#198754',
                '#ffc107',
                '#dc3545',
                '#6f42c1'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
</script>

<script>
const ctx2 = document.getElementById('chartTransaksi');

new Chart(ctx2, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($labels_transaksi); ?>,
        datasets: [{
            label: 'Jumlah Transaksi',
            data: <?php echo json_encode($data_transaksi); ?>,
            borderWidth: 3,
            tension: 0.4,
            fill: true,
            backgroundColor: 'rgba(13, 110, 253, 0.1)', // biru soft
            borderColor: '#0d6efd',
            pointBackgroundColor: '#0d6efd'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true
            }
        },
        
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1 // biar integer (1,2,3)
                }
            }
        },
        tooltip: {
    callbacks: {
        label: function(context){
            return context.dataset.label + ': ' + context.raw.toLocaleString();
        }
    }
}
    }
});
</script>
  </main>
  </div>
</body>

</html>