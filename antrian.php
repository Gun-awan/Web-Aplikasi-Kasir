<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Antrian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

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
                    <button class="btn btn-outline-primary w-100 mb-2"
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

function updateStatus(id,status){

    fetch('update_status.php',{
        method:'POST',
        headers:{
            'Content-Type':'application/x-www-form-urlencoded'
        },
        body:'id='+id+'&status='+status
    })
    .then(response=>response.text())
    .then(data=>{
        location.reload();
    });
}

function cetakStruk(id){
    window.open('cetak_struk.php?id='+id,'_blank');
}

function cetakStruk(id){
    window.open("cetak_struk.php?id="+id,"_blank");
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>