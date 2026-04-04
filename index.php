<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
.navbar input{
    border-radius: 4px;
    flex:none;
}

.navbar button{
    min-width:100px;
}
.navbar{
    box-shadow:0 2px 6px rgba(0,0,0,0.15);
    overflow-x:auto;
    white-space:nowrap;
}
.btn-warning{
    margin-left: 20px;
   
}
.sidebar{
    position:fixed;
    top:0;
    left:-250px;
    width:250px;
    height:100%;
    background:#212529;
    transition:0.3s;
    z-index:2000;
}

.sidebar a{
    display:block;
    color:white;
    padding:12px;
    text-decoration:none;
    border-radius:5px;
    margin-bottom:5px;
}

.sidebar a:hover{
    background:#343a40;
}

.overlay{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.4);
    display:none;
    z-index:1500;
}
.namacust{
    border-radius: 25px;
}

.bi-list{
    margin-left: 8px;
}
::-webkit-scrollbar {
    width: 6px;
}
.plus{
    margin-right: 29px;
}
.totantrian{
    margin-left: 100px;
}
</style>
</head>
<body>
<!-- Sidebar -->
<div id="sidebar" class="sidebar">

    <div class="p-3">

        <h4 class="text-white">Menu Kasir</h4>
        <hr class="text-white">

        <a href="#">Dashboard</a>
        <a href="#">Data Produk</a>
        <a href="#">Transaksi</a>
        <a href="#">Laporan</a>
        <a href="#">Logout</a>

    </div>

</div>

<!-- Overlay -->
<div id="overlay" class="overlay" onclick="closeSidebar()"></div>

<div class="container-fluid">

<!-- Navbar -->
            
            <nav class="navbar sticky-top px-3 mb-2" style="background:#4fc3f7; z-index:1000;">
    <div class="d-flex flex-nowrap align-items-center w-100">

        <i class="bi bi-list"
           onclick="openSidebar()"
           style="font-size:30px; cursor:pointer; color:white; margin-right:15px;"></i>

        <button class="btn btn-outline-light me-2">Semua</button>
        <button class="btn btn-outline-light me-2">Isi 3</button>
        <button class="btn btn-outline-light me-2">Isi 4</button>
        <button class="btn btn-outline-light me-2">Isi 5</button>
        <button class="btn btn-outline-light me-2">Sticky</button>

        <input type="text"
            id="searchProduk"
            class="form-control mx-2"
            style="width:260px; flex:0 0 260px;"
            placeholder="Cari produk..."
            onkeyup="searchProduk()">

        
            <h3 class="text-white totantrian"><strong>Total Antrian : 19</strong></h3>
        

    </div>
</nav>
    <div class="row align-items-start" style="height:calc(100vh - 70px);">

        <!-- Area Produk -->
        <div class="col-md-8 d-flex flex-column">

    <div class="card rounded-3 shadow-sm h-100">

        <div class="card-body">

            <div style="overflow-y:scroll; height:calc(100vh - 140px);">
                <div class="row">

                    <?php
                    $produk = mysqli_query($conn,"SELECT * FROM produk");
                    while($p = mysqli_fetch_array($produk)){
                    ?>
                    <div class="col-md-3 mb-3 produk-item">
                        <div class="card p-2 pesanan">
                            <img src="assets/img/<?php echo $p['gambar']; ?>" height="120">
                            <h6 class="nama-produk"><?php echo $p['nama']; ?></h6>
                            <p>Rp<?php echo number_format($p['harga']); ?></p>
                            <button class="btn btn-primary"
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

            <div class="mb-2">

                <div class="d-flex align-items-center gap-2">

                    <input type="text" id="customer" name="customer" class="form-control namacust" placeholder="Nama Customer" required>

                    <button class="btn p-1 mx-1" onclick="">
                    <i class="bi bi-cart3" style="font-size:28px; color:#198754;"></i>
                    <!-- <span id="cartCount" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        0
                    </span> -->
                    </button>
                    

                </div>

            </div>

            <div id="cartArea" class="flex-grow-1 overflow-y-scroll">
                <div id="cart"></div>
            </div>

            <h4 class="mt-3">Total: Rp <span id="total">0</span></h4>

            <input type="hidden" name="data" id="dataKeranjang">
            <input type="hidden" name="total" id="totalInput">

            <div class="d-flex gap-2">
                <button type="button" class="btn btn-danger w-50" onclick="batalKeranjang()">Batal</button>
                <button type="button" class="btn btn-success w-50" onclick="cekSimpan()">Simpan</button>
            </div>

        </form>

    </div>

</div>
        <script>
function openSidebar(){
    document.getElementById("sidebar").style.left = "0";
    document.getElementById("overlay").style.display = "block";
}

function closeSidebar(){
    document.getElementById("sidebar").style.left = "-250px";
    document.getElementById("overlay").style.display = "none";
}
</script>

<script>
function searchProduk(){
    let input = document.getElementById("searchProduk").value.toLowerCase();
    let items = document.querySelectorAll(".produk-item");

    items.forEach(item=>{
        let nama = item.querySelector(".nama-produk").innerText.toLowerCase();

        if(nama.includes(input)){
            item.style.display = "";
        }else{
            item.style.display = "none";
        }
    });
}
</script>

<script>
let keranjang = [];

function tambahKeranjang(id,nama,harga){

    let existing = keranjang.find(item => item.id == id);

    if(existing){
        existing.qty++;
    }else{
        keranjang.push({
            id:id,
            nama:nama,
            harga:harga,
            qty:1
        });
    }

    tampilkanKeranjang();
}

function tambahQty(index){
    keranjang[index].qty++;
    tampilkanKeranjang();
}
function cekSimpan(){

    let customer = document.getElementById("customer").value.trim();

    if(keranjang.length === 0){
        alert("Pilih produk terlebih dahulu");
        return;
    }

    if(customer === ""){
        alert("Nama customer harus diisi");
        return;
    }

    document.getElementById("formKasir").submit();
}

function batalKeranjang(){
    if(confirm("Batalkan Pesanan?")){
        keranjang = [];
        tampilkanKeranjang();

        document.getElementById("customer").value = "";
    }
}

function kurangQty(index){
    if(keranjang[index].qty > 1){
        keranjang[index].qty--;
    }else{
        keranjang.splice(index,1);
    }

    tampilkanKeranjang();
}

function hapusItem(index){
    keranjang.splice(index,1);
    tampilkanKeranjang();
}

function tampilkanKeranjang(){
    let html = "";
    let total = 0;

    keranjang.forEach((item,index)=>{

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
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>