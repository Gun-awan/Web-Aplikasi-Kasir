<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Income</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="style/main.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .finance-grid {
            display: grid;
            gap: 20px;
            grid-template-columns: repeat(3, 1fr);
        }

        .finance-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
            padding: 20px;
            height: 432px;
        }

        .finance-card h3 {
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background: rgb(25, 27, 25);
            color: white;
        }

        .export-btn {
            padding: 10px 18px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-right: 10px;
        }

        .pdf {
            background: #dc3545;
            color: white;
        }

        .judul {
            height: 72px;
        }

        .export-btn {
            margin-bottom: 10px;
        }

        .sidebar-menu a:hover {
            background: #ffffff88;
            color: rgb(25, 27, 25);
            border-radius: 30px 0px 0px 30px;
        }

        .judul span {
            padding-right: 25px;
        }

        .excel {
            background: #198754;
            color: white;
        }

        .finance-card {
            background: #fff;
            padding: 15px;
            border-radius: 15px;
            height: 480px;
        }

        .table-wrapper {
            max-height: 380px;
            overflow-y: auto;
        }

        /* optional biar header tabel ikut "nempel" */
        .table-wrapper th {
            position: sticky;
            top: 0;

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

.modal-backdrop.show {
  z-index: 1050 !important;
}

/* khusus backdrop kedua */
.modal-backdrop.show:nth-of-type(2) {
  z-index: 1040 !important;
}
    </style>
</head>
<?php $q = mysqli_query($conn, "
SELECT DATE(tanggal) as tgl, SUM(total) as income
FROM transaksi
WHERE status='selesai'
AND MONTH(tanggal) = MONTH(CURDATE())
AND YEAR(tanggal) = YEAR(CURDATE())
GROUP BY DATE(tanggal)
ORDER BY tgl ASC
"); ?>

<body>

    <div class="sidebar">
        <div class="sidebar-brand">
            <h4><strong><span class="lab la-accusoft"></span>The Cashier</strong></h4>
        </div>

        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="dashboard.php"><span class="las la-igloo"></span>
                        <span> Dashboard</span></a>
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
                <li><a href="finance.php" class="active"><span class="las la-money-bill-wave">
                        </span><span> Income</span></a>
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
            <h4><span class="las la-money-bill-wave"></span><strong>Income</strong></h4>
            <div class="user-wrapper">
        <img src="" width="40px" height="40px" alt="">
        <div>
          <h4>Admin</h4>
          <small>Admin</small>
        </div>
      </div>
        </header>

        <main>

            <div class="finance-grid">

    <!-- ================== CARD HARIAN ================== -->
    <div class="finance-card">
        <h5>Income Harian (1 Bulan)</h5>

        <div class="table-wrapper">
            <table>
                <tr>
                    <th>Tanggal</th>
                    <th>Penghasilan</th>
                </tr>

                <?php
                $bulan = date('m');
                $tahun = date('Y');
                $hari_ini = date('d');

                for ($i = 1; $i <= $hari_ini; $i++) {

                    $tgl = $tahun . '-' . $bulan . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);

                    $q = mysqli_query($conn, "
                        SELECT SUM(total) as income
                        FROM transaksi
                        WHERE status='selesai'
                        AND DATE(tanggal) = '$tgl'
                    ");

                    $d = mysqli_fetch_array($q);
                    $income = $d['income'] ? $d['income'] : 0;
                ?>
                    <tr>
                        <td>
                            <!-- <a href="#"
                               data-bs-toggle="modal"
                               data-bs-target="#detailModal"
                               data-tanggal="<?php echo $tgl; ?>"> -->
                                <?php echo date('d M Y', strtotime($tgl)); ?>
                            </a>
                        </td>
                        <td>Rp <?php echo number_format($income); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>


    <!-- ================== CARD BULANAN ================== -->
    <div class="finance-card">
        <h5>Income Bulanan (1 Tahun)</h5>

        <div class="table-wrapper">
            <table>
                <tr>
                    <th>Bulan</th>
                    <th>Penghasilan</th>
                </tr>

                <?php
$tahun = date('Y');
$bulan_sekarang = date('m');

$nama_bulan = [
    1 => 'Januari','Februari','Maret','April','Mei','Juni',
    'Juli','Agustus','September','Oktober','November','Desember'
];

for ($i = 1; $i <= $bulan_sekarang; $i++) {

    $bulan_format = str_pad($i, 2, '0', STR_PAD_LEFT);

    $q = mysqli_query($conn, "
        SELECT SUM(total) as income
        FROM transaksi
        WHERE status='selesai'
        AND MONTH(tanggal) = '$bulan_format'
        AND YEAR(tanggal) = '$tahun'
    ");

    $d = mysqli_fetch_array($q);
    $income = $d['income'] ? $d['income'] : 0;
?>
<tr>
    <td>
        <a href="#"
           data-bs-toggle="modal"
           data-bs-target="#modalBulan"
           data-bulan="<?php echo $bulan_format; ?>"
           data-nama="<?php echo $nama_bulan[$i]; ?>">
           
           <?php echo $nama_bulan[$i]; ?>
        </a>
    </td>
    <td>Rp <?php echo number_format($income); ?></td>
</tr>
<?php } ?>
            </table>
        </div>
    </div>


    <!-- ================== CARD TAHUNAN ================== -->
    <div class="finance-card">
        <h5>Income Tahunan</h5>

        <div class="table-wrapper">
            <table>
                <tr>
                    <th>Tahun</th>
                    <th>Penghasilan</th>
                </tr>

                <?php
                $q = mysqli_query($conn, "
                    SELECT YEAR(tanggal) as tahun, SUM(total) as income
                    FROM transaksi
                    WHERE status='selesai'
                    GROUP BY YEAR(tanggal)
                    ORDER BY tahun ASC
                ");

                while ($d = mysqli_fetch_array($q)) {
                ?>
                    <tr>
                        <td><?php echo $d['tahun']; ?></td>
                        <td>Rp <?php echo number_format($d['income']); ?></td>
                    </tr>
                    
                <?php } ?>
            </table>
        </div>
    </div>

</div>


<!-- ================== MODAL Harian ================== -->
<!-- <div class="modal fade" id="detailModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4">

      <div class="modal-header">
        <h5 class="modal-title" id="judulHarian">
            Detail Transaksi
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body" id="modalBody">
        <p>Loading...</p>
      </div>

    </div>
  </div>
</div> -->

<!-- ================== MODAL Bulanan =============== -->
<div class="modal fade" id="modalBulan" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4">

      <div class="modal-header">
        <h5 class="modal-title" id="judulBulan">
          Detail Bulan
        </h5>
        
        <!-- Tombol Export -->
        <div>
          <button class="btn btn-danger btn-sm me-2 mx-3" id="exportPdfBulan">
            PDF
          </button>
          <button class="btn btn-success btn-sm" id="exportExcelBulan">
            Excel
          </button>
        </div>

        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal"></button> -->
      </div>

      <div class="modal-body" id="isiBulan">
        <p>Loading...</p>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="modalTanggal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4">

      <div class="modal-header">
        <h5 class="modal-title" id="judulTanggal">
          Detail Transaksi
        </h5>

        <!-- Tombol Export -->
        <div>
          <button class="btn btn-danger btn-sm me-2 mx-3" id="exportPdfTanggal">
            PDF
          </button>
          <button class="btn btn-success btn-sm" id="exportExcelTanggal">
            Excel
          </button>
        </div>

        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal"></button> -->
      </div>

      <div class="modal-body" id="isiTanggal">
        <p>Loading...</p>
      </div>

    </div>
  </div>
</div>


<!-- ================== JAVASCRIPT ================== -->
 <script>

   let currentBulan = null;
let currentTanggal = null;

// ================= BULAN =================
document.getElementById("modalBulan").addEventListener("show.bs.modal", function (event) {

    let button = event.relatedTarget;

    currentBulan = button.getAttribute("data-bulan");
    let nama = button.getAttribute("data-nama");

    document.getElementById("judulBulan").innerText =
        "Detail Bulan " + nama;

    fetch("get_bulan.php?bulan=" + currentBulan)
        .then(response => response.text())
        .then(data => {
            document.getElementById("isiBulan").innerHTML = data;
        });

});

// ================= TANGGAL =================
document.addEventListener("click", function(e){

    if(e.target.classList.contains("openTanggal")){

        e.preventDefault();

        currentTanggal = e.target.getAttribute("data-tanggal");

        let modalBulan = bootstrap.Modal.getInstance(document.getElementById("modalBulan"));
        let modalTanggal = new bootstrap.Modal(document.getElementById("modalTanggal"));

        if(modalBulan){
            modalBulan.hide();
        }

        document.getElementById("judulTanggal").innerText =
            "Detail Transaksi - " + currentTanggal;

        fetch("get_transaksi2.php?tanggal=" + currentTanggal)
            .then(res => res.text())
            .then(data => {
                document.getElementById("isiTanggal").innerHTML = data;
                modalTanggal.show();
            });

    }

});

// ================= EXPORT =================
document.getElementById("exportPdfBulan").onclick = function(){
    if(!currentBulan) return alert("Bulan belum dipilih");
    window.open("export_pdf_bulan.php?bulan=" + currentBulan);
};

document.getElementById("exportExcelBulan").onclick = function(){
    if(!currentBulan) return alert("Bulan belum dipilih");
    window.open("export_excel_bulan.php?bulan=" + currentBulan);
};

document.getElementById("exportPdfTanggal").onclick = function(){
    if(!currentTanggal) return alert("Tanggal belum dipilih");
    window.open("export_pdf_tanggal.php?tanggal=" + currentTanggal);
};

document.getElementById("exportExcelTanggal").onclick = function(){
    if(!currentTanggal) return alert("Tanggal belum dipilih");
    window.open("export_excel_tanggal.php?tanggal=" + currentTanggal);
};
 </script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    let modal = document.getElementById("detailModal");

    modal.addEventListener("show.bs.modal", function (event) {

        let button = event.relatedTarget;
        let tanggal = button.getAttribute("data-tanggal");

        // format tanggal ke tampilan
        document.getElementById("modalTanggal").innerText =
            "Detail Transaksi - " + tanggal;

        // ambil data dari PHP
        fetch("get_transaksi.php?tanggal=" + tanggal)
            .then(response => response.text())
            .then(data => {
                document.getElementById("modalBody").innerHTML = data;
            });

    });

});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    let modal = document.getElementById("modalBulan");

    modal.addEventListener("show.bs.modal", function (event) {

        let button = event.relatedTarget;

        let bulan = button.getAttribute("data-bulan");
        let nama = button.getAttribute("data-nama");

        // set judul modal
        document.getElementById("judulBulan").innerText =
            "Detail Bulan " + nama;

        // fetch data dari PHP
        fetch("get_bulan.php?bulan=" + bulan)
            .then(response => response.text())
            .then(data => {
                document.getElementById("isiBulan").innerHTML = data;
            });

    });

});
</script>
<script>
document.addEventListener("click", function(e){

    if(e.target.classList.contains("openTanggal")){

        e.preventDefault();

        let tanggal = e.target.getAttribute("data-tanggal");

        let modalBulan = bootstrap.Modal.getInstance(document.getElementById("modalBulan"));
        let modalTanggal = new bootstrap.Modal(document.getElementById("modalTanggal"));

        // tutup modal bulan dulu
        if(modalBulan){
            modalBulan.hide();
        }

        // set judul
        document.getElementById("judulTanggal").innerText =
            "Detail Transaksi - " + tanggal;

        // load data
        fetch("get_transaksi2.php?tanggal=" + tanggal)
            .then(res => res.text())
            .then(data => {
                document.getElementById("isiTanggal").innerHTML = data;

                // buka modal tanggal
                modalTanggal.show();
            });

    }

});


</script>
<!-- <script>
document.addEventListener("DOMContentLoaded", function () {

    let modalTanggal = document.getElementById("modalTanggal");

    modalTanggal.addEventListener("show.bs.modal", function (event) {

        let button = event.relatedTarget;
        let tanggal = button.getAttribute("data-tanggal");

        // ubah judul
        document.getElementById("judulTanggal").innerText =
            "Detail Transaksi - " + tanggal;

        // ambil data dari PHP
        fetch("get_transaksi2.php?tanggal=" + tanggal)
            .then(response => response.text())
            .then(data => {
                document.getElementById("isiTanggal").innerHTML = data;
            });

    });

});
</script> -->

        </main>
    </div>
    

</body>

</html>