<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>

<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['user_id'];

$user = mysqli_fetch_array(mysqli_query($conn, "
  SELECT * FROM users WHERE id_users='$id_user'
"));

$edit_mode = false;
$data_edit = [];
$detail_edit = [];

if (isset($_GET['edit_id'])) {
    $edit_mode = true;
    $id = $_GET['edit_id'];

    // Ambil transaksi
    $q = mysqli_query($conn, "SELECT * FROM transaksi WHERE id='$id'");
    $data_edit = mysqli_fetch_array($q);

    // Ambil detail
    $q2 = mysqli_query($conn, "
        SELECT dt.*, p.nama, p.harga
        FROM detail_transaksi dt
        JOIN produk p ON dt.produk_id = p.id
        WHERE dt.transaksi_id = '$id'
    ");

    while ($d = mysqli_fetch_array($q2)) {
        $detail_edit[] = $d;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">


    <style>
        body {
            margin: 0px;
            font-family: 'Poppins', sans-serif;

        }

        .container-fluid {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        .navbar input {
            border-radius: 4px;
            flex: none;
        }

        .navbar button {
            min-width: 100px;
        }

        .navbar {
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            overflow-x: auto;
            white-space: nowrap;
            height: 75px;
        }

        .btn-warning {
            margin-left: 20px;

        }

        .sidebar {
            position: fixed;
            top: 0;
            left: -250px;
            width: 250px;
            height: 100%;
            background: #212529;
            transition: 0.3s;
            z-index: 2000;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 12px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 5px;
        }

        .sidebar a:hover {
            background: #343a40;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            display: none;
            z-index: 1500;
        }

        .namacust {
            border-radius: 25px;
        }

        .bi-list {
            margin-left: 8px;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        .plus {
            margin-right: 29px;
        }

        .totantrian {
            margin-left: 120px;
            margin-right: 80px;
        }

        .produk {
            background: #80878d;
            margin-top: 15px;
            margin-left: 15px;
        }

        .besar {
            background: #eaebec;
        }

        .pesanan {
            background: #ffffff;
            color: rgb(25, 27, 25);
            margin-left: 8px;
            margin-right: 8px;
        }

        .la-users {
            color: #ffffff;
            margin-right: 20px;
        }

        .nama-produk {
            margin-top: 3px;
        }
    </style>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }

        .container-fluid {
            padding: 0 !important;
        }

        .row {
            --bs-gutter-x: 0;
            --bs-gutter-y: 0;
        }

        .col-md-8,
        .col-md-4 {
            padding: 0;
        }

        .produk {
            background: #80878d;
            border-radius: 0;
            height: 100%;
            margin-right: 30px;
        }

        .nol {
            margin-right: 15px;
        }

        .master {
            margin-left: 17px;
            margin-top: 350px;
            padding-right: 14px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">

        <div class="p-3">

            <h4 class="text-white">Menu Kasir</h4>
            <hr class="text-white">
            <a href="antrian.php">Antrian</a>
            <a href="dashboard.php">Data Master</a>


        </div>
        <div class="master">
            <a href="logout.php">Logout</a>
        </div>

    </div>

    <!-- Overlay -->
    <div id="overlay" class="overlay" onclick="closeSidebar()"></div>

    <div class="container-fluid besar">

        <!-- Navbar -->

        <nav class="navbar sticky-top px-3 mb-2" style="background:rgb(25, 27, 25);; z-index:1000;">
            <div class="d-flex flex-nowrap align-items-center justify-content-center w-100">

                <i class="bi bi-list"
                    onclick="openSidebar()"
                    style="font-size:30px; cursor:pointer; color:white; margin-right:15px;"></i>

                    <div class="d-flex flex-nowrap mx-auto">

                <button class="btn btn-outline-light me-2 kategori-btn active-kategori"
                    onclick="filterKategori('Semua', this)">Semua</button>

                <button class="btn btn-outline-light me-2 kategori-btn"
                    onclick="filterKategori('7', this)">Isi 3</button>

                <button class="btn btn-outline-light me-2 kategori-btn"
                    onclick="filterKategori('9', this)">Isi 4</button>

                <button class="btn btn-outline-light me-2 kategori-btn"
                    onclick="filterKategori('6', this)">Isi 5</button>

                <button class="btn btn-outline-light me-2 kategori-btn"
                    onclick="filterKategori('10', this)">Sticky Milk</button>

                    </div>

                <input type="text"
                    id="searchProduk"
                    class="form-control mx-2"
                    style="width:260px; flex:0 0 260px;"
                    placeholder="Cari produk..."
                    onkeyup="searchProduk()">


                <h3 class="text-white totantrian"><strong>Total Antrian : <?php
                                                                            $q1 = mysqli_query($conn, "
                        SELECT * FROM transaksi
                        WHERE status='baru'
                        ORDER BY id ASC
                    ");

                                                                            echo mysqli_num_rows($q1);
                                                                            ?></strong>
                </h3>
                <h2><a href="antrian.php"><span class="las la-users"></span></a></h2>


            </div>
        </nav>
        <div class="row align-items-start" style="height:calc(100vh - 70px);">

            <!-- Area Produk -->
            <div class="col-md-8 d-flex flex-column">

                <div class="card rounded-3 shadow-sm h-100 produk">

                    <div class="card-body">

                        <div style="overflow-y:scroll; height:calc(100vh - 140px);">
                            <div class="row">

                                <?php
                                $produk = mysqli_query($conn, "SELECT * FROM produk");
                                while ($p = mysqli_fetch_array($produk)) {
                                ?>
                                    <!-- <div class="col-md-3 mb-3 produk-item">-->
                                    <div class="col-md-3 mb-3 produk-item" data-kategori="<?php echo $p['id_kategori']; ?>">
                                        <div class="card p-2 pesanan">
                                            <img src="image/<?php echo $p['gambar']; ?>" height="120"
                                                style="border-radius:15px; object-fit:cover;">
                                            <h6 class="nama-produk"><?php echo $p['nama']; ?></h6>
                                            <p>Rp <?php echo number_format($p['harga']); ?></p>
                                            <button class="btn btn-dark"
                                                onclick="tambahKeranjang(
                                    <?php echo $p['id']; ?>,
                                    '<?php echo $p['nama']; ?>',
                                    <?php echo $p['harga']; ?>
                                )">
                                                Tambah
                                            </button>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <!-- Keranjang -->

            <div class="col-md-4 position-sticky" style="top:70px; height:calc(100vh - 70px);">

                <div class="p-3 d-flex flex-column h-100">

                    <form id="formkasir" action="simpan_transaksi.php" method="POST" class="d-flex flex-column h-100">

                        <?php if ($edit_mode): ?>
                            <input type="hidden" name="edit_id" value="<?php echo $data_edit['id']; ?>">
                        <?php endif; ?>

                        <div class="mb-2">

                            <div class="d-flex align-items-center gap-2">


                                <!-- <input type="text" id="customer" name="customer" class="form-control namacust" placeholder="Nama Customer" required> -->
                                <input type="text"
    id="customer"
    name="customer"
    class="form-control namacust"
    value="<?php echo $edit_mode ? $data_edit['customer'] : ''; ?>"
    placeholder="Nama Customer"
    onkeydown="handleEnter(event)"
    required>

                                <div class="position-relative nol">

                                    <i class="bi bi-cart" style="font-size:28px; color:grey;"></i>

                                    <span id="badgeCart"
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        0
                                    </span>

                                </div>


                            </div>

                        </div>

                        <div id="cartArea" class="flex-grow-1 overflow-y-scroll">
                            <div id="cart"></div>
                        </div>

                        <h4 class="mt-3">Total: Rp <span id="total">0</span></h4>

                        <input type="hidden" name="data" id="dataKeranjang">
                        <input type="hidden" name="total" id="totalInput">

                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-dark w-50" onclick="batalKeranjang()">Batal</button>
                            <button type="button" class="btn btn-dark w-50" onclick="cekSimpan()">Simpan</button>
                        </div>

                    </form>

                </div>

            </div>
            <script>
                function openSidebar() {
                    document.getElementById("sidebar").style.left = "0";
                    document.getElementById("overlay").style.display = "block";
                }

                function closeSidebar() {
                    document.getElementById("sidebar").style.left = "-250px";
                    document.getElementById("overlay").style.display = "none";
                }
            </script>

            <script>
                function searchProduk() {
                    let input = document.getElementById("searchProduk").value.toLowerCase();
                    let items = document.querySelectorAll(".produk-item");

                    items.forEach(item => {
                        let nama = item.querySelector(".nama-produk").innerText.toLowerCase();

                        if (nama.includes(input)) {
                            item.style.display = "";
                        } else {
                            item.style.display = "none";
                        }
                    });
                }
            </script>

            <script>
                let keranjang = [];

                <?php if ($edit_mode): ?>
                    keranjang = [
                        <?php foreach ($detail_edit as $d): ?> {
                                id: <?php echo $d['produk_id']; ?>,
                                nama: "<?php echo $d['nama']; ?>",
                                harga: <?php echo $d['harga']; ?>,
                                qty: <?php echo $d['qty']; ?>
                            },
                        <?php endforeach; ?>
                    ];
                <?php endif; ?>

                function tambahKeranjang(id, nama, harga) {
                    let existing = keranjang.find(item => item.id == id);

                    if (existing) {
                        existing.qty++;
                    } else {
                        keranjang.push({
                            id: id,
                            nama: nama,
                            harga: harga,
                            qty: 1
                        });
                    }

                    tampilkanKeranjang();
                }

                document.addEventListener("DOMContentLoaded", function() {
                    tampilkanKeranjang();
                });

                function filterKategori(kategori, tombol) {

                    let items = document.querySelectorAll(".produk-item");

                    items.forEach(item => {
                        let kat = item.getAttribute("data-kategori");

                        if (kategori === "Semua" || kat === kategori) {
                            item.style.display = "";
                        } else {
                            item.style.display = "none";
                        }
                    });

                    let semuaTombol = document.querySelectorAll(".kategori-btn");

                    semuaTombol.forEach(btn => {
                        btn.classList.remove("btn-light");
                        btn.classList.add("btn-outline-light");
                    });

                    tombol.classList.remove("btn-outline-light");
                    tombol.classList.add("btn-light");
                }

                function handleEnter(event) {
                    if (event.key === "Enter") {
                        event.preventDefault();
                        cekSimpan();
                    }
                }

                function tambahQty(index) {
                    keranjang[index].qty++;
                    tampilkanKeranjang();
                }

                let isSaving = false;

function cekSimpan() {

    if (isSaving) return; // 🔥 cegah double klik / auto spam

    let customer = document.getElementById("customer").value.trim();

    if (keranjang.length === 0) {
        alert("Belum ada barang");
        return;
    }

    if (customer === "") {
        alert("Masukan nama customer");
        return;
    }

    // 🔥 KONFIRMASI DULU
    let konfirmasi = confirm("Simpan pesanan?");
    if (!konfirmasi) return;

    isSaving = true;

    let formData = new FormData(document.getElementById("formkasir"));

    fetch('simpan_transaksi.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        window.location = 'index.php';
    });
}

                // // function cekSimpan() {

                // //     let customer = document.getElementById("customer").value.trim();

                // //     if (keranjang.length === 0) {
                // //         alert("Pilih produk terlebih dahulu");
                // //         return;
                // //     }

                // //     if (customer === "") {
                // //         alert("Nama customer harus diisi");
                // //         return;
                // //     }

                // //     let formData = new FormData(document.getElementById("formkasir"));

                // //     fetch('simpan_transaksi.php', {
                // //             method: 'POST',
                // //             body: formData
                // //         })
                // //         .then(response => response.text())
                // //         .then(data => {
                // //             alert("Pesanan berhasil disimpan");
                // //             window.location = 'index.php';

                // //             keranjang = [];
                // //             tampilkanKeranjang();
                // //             document.getElementById("customer").value = "";
                // //         });
                // }

                function batalKeranjang() {
                    if (confirm("Batalkan Pesanan?")) {
                        keranjang = [];
                        tampilkanKeranjang();

                        document.getElementById("customer").value = "";
                    }
                }

                function kurangQty(index) {
                    if (keranjang[index].qty > 1) {
                        keranjang[index].qty--;
                    } else {
                        keranjang.splice(index, 1);
                    }

                    tampilkanKeranjang();
                }

                function hapusItem(index) {
                    keranjang.splice(index, 1);
                    tampilkanKeranjang();
                }

                function tampilkanKeranjang() {
                    let html = "";
                    let total = 0;

                    keranjang.forEach((item, index) => {

                        let subtotal = item.harga * item.qty;
                        total += subtotal;


                        html += `
<div class="py-2 border-bottom">

    <div class="d-flex justify-content-between align-items-center">

        <!-- Qty -->
        <div style="width:30px;">
            ${item.qty}
        </div>

        <!-- Nama Produk -->
        <div class="flex-grow-1">

            <div>
                <strong>${item.nama}</strong>
            </div>

            <small class="text-muted">
                Rp ${item.harga.toLocaleString('id-ID')}
            </small>

        </div>

        <!-- Tombol qty -->
        <div class="d-flex align-items-center">

            <button class="btn btn-sm btn-light border mx-2"
                onclick="kurangQty(${index})">-</button>

            <button class="btn btn-sm btn-light border plus"
                onclick="tambahQty(${index})">+</button>

        </div>

        <!-- Subtotal -->
        <div style="width:90px; text-align:right;">
            <strong>Rp ${subtotal.toLocaleString('id-ID')}</strong>
        </div>

        <div>
                <button class="btn btn-danger p-1 mx-2"
                    onclick="hapusItem(${index})">
                    <i class="bi bi-trash text-white"></i>
                    </button>
            </div>

    </div>

</div>
`;

                    });

                    document.getElementById("cart").innerHTML = html;
                    document.getElementById("total").innerText = total.toLocaleString('id-ID');
                    document.getElementById("totalInput").value = total;
                    document.getElementById("dataKeranjang").value = JSON.stringify(keranjang);
                    let totalQty = keranjang.reduce((sum, item) => sum + item.qty, 0);
                    document.getElementById("badgeCart").innerText = totalQty;
                }
            </script>
            <script>
                window.addEventListener("pageshow", function(event) {
                    if (event.persisted || window.performance.navigation.type === 2) {
                        window.location.reload();
                    }
                });
            </script>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>