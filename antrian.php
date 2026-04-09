<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Antrian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css" >
  <link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
     <link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css" >
  <link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body{
    background: #80878d;
margin: 0px;
    font-family: 'Poppins', sans-serif;

        }
        
.navbar input{
    border-radius: 4px;
    flex:none;
}

.navbar{
    box-shadow:0 2px 6px rgba(0,0,0,0.15);
    overflow-x:auto;
    white-space:nowrap;
    height: 75px;
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
    background:rgba(0, 0, 0, 0.7);
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

.totantrian{
    margin-left: 120px;
}
.produk{
    background: #80878d;
}

.card{
    background: #f7fbff;
}

.pesanan{
    background: #ffffff;
    color: rgb(25, 27, 25);
}
.la-receipt{
    color: #ffffff;
    padding-left: 920px;
}

</style>
<style>
html, body{
    margin:0;
    padding:0;
    height:100%;
    overflow:hidden;
}

.container-fluid{
    padding:0 !important;
}

.row{
    --bs-gutter-x:0;
    --bs-gutter-y:0;
}

.col-md-8,
.col-md-4{
    padding:0;
}
.card{
    margin-left: 10px;
    margin-right: 10px;
}
.master{
    margin-left: 17px;
    margin-top: 350px;
}
</style>
</head>
<body>
    <!-- Sidebar -->
<div id="sidebar" class="sidebar">

    <div class="p-3">

        <h4 class="text-white">Menu Kasir</h4>
        <hr class="text-white">
        <a href="index.php">Kasir</a>
        <a href="#">Logout</a>
        

    </div>
    <div class="master">
    <a href="#">Data Master</a>
    </div>
</div>

<!-- Overlay -->
<div id="overlay" class="overlay" onclick="closeSidebar()"></div>

<div class="container-fluid">

<!-- Navbar -->
            
            <nav class="navbar sticky-top px-3 mb-2" style="background:rgb(25, 27, 25);; z-index:1000;">
    <div class="d-flex flex-nowrap align-items-center w-100">

        <i class="bi bi-list"
           onclick="openSidebar()"
           style="font-size:30px; cursor:pointer; color:white; margin-right:15px;"></i>

           <h4 class="text-white">Daftar Antrian</h4>

        <!-- <input type="text"
            id="searchNama"
            class="form-control mx-2"
            style="width:260px; flex:0 0 260px;"
            placeholder="Cari ....."
            onkeyup="searchNama()"> 

            <h2><a href="index.php"><span class="las la-receipt"></span></a></h2>-->

    </div>
</nav>

<div class="container mt-4">

    <div class="row">

        <!-- Antrian Sekarang -->
        <div class="col-md-4">
            <div class="card shadow-sm rounded-4 p-3">
                <h5>Antrian Sekarang : 
                    <?php
                    $q1 = mysqli_query($conn,"
                        SELECT * FROM transaksi
                        WHERE status='baru'
                        ORDER BY id ASC
                    ");

                    echo mysqli_num_rows($q1);
                    ?>
                </h5>

                <?php
                while($t = mysqli_fetch_array($q1)){
                ?>
                    <button class="btn btn-primary w-100 mb-2"
                        data-bs-toggle="modal"
                        data-bs-target="#modal<?php echo $t['id']; ?>">
                        <?php echo $t['customer']; ?>
                    </button>

                    <?php include 'modal_antrian.php'; ?>

                <?php } ?>
            </div>
        </div>

        <!-- Pending -->
        <div class="col-md-4">
            <div class="card shadow-sm rounded-4 p-3">
                <h5>Antrian Pending :
                    <?php
                    $q2 = mysqli_query($conn,"SELECT * FROM transaksi WHERE status='pending'");
                    echo mysqli_num_rows($q2);
                    ?>
                </h5>

                <?php
                while($t = mysqli_fetch_array($q2)){
                ?>
                    <button class="btn btn-warning w-100 mb-2"
                        data-bs-toggle="modal"
                        data-bs-target="#modal<?php echo $t['id']; ?>">
                        <?php echo $t['customer']; ?>
                    </button>

                    <?php include 'modal_antrian.php'; ?>

                <?php } ?>
            </div>
        </div>

        <!-- Selesai -->
        <div class="col-md-4">
            <div class="card shadow-sm rounded-4 p-3">
                <h5>Antrian Selesai :
                    <?php
                    $q3 = mysqli_query($conn,"SELECT * FROM transaksi WHERE status='selesai'");
                    echo mysqli_num_rows($q3);
                    ?>
                </h5>

                <?php
                while($t = mysqli_fetch_array($q3)){
                ?>
                    <button class="btn btn-success w-100 mb-2"
                        data-bs-toggle="modal"
                        data-bs-target="#modal<?php echo $t['id']; ?>">
                        <?php echo $t['customer']; ?>
                    </button>

                    <?php include 'modal_antrian.php'; ?>

                <?php } ?>
            </div>
        </div>

    </div>

</div>
<script>
function searchNama(){
    let input = document.getElementById("searchNama").value.toLowerCase();
    let items = document.querySelectorAll(".antrian-item");

    items.forEach(item=>{
        let nama = item.innerText.toLowerCase();

        if(nama.includes(input)){
            item.style.display = "";
        }else{
            item.style.display = "none";
        }
    });
}
</script>

<script>
function updateStatus(id,status){
    window.location.href='update_status.php?id='+id+'&status='+status;
}
</script>

<script>



function cetakStruk(id){
    window.open('cetak_struk.php?id='+id,'_blank');
}

function cetakStruk(id){
    window.open("cetak_struk.php?id="+id,"_blank");
}
</script>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>