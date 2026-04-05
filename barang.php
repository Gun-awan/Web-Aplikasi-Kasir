<?php include 'koneksi.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <h3>Data Barang</h3>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahModal">
        Tambah Barang
    </button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

        <?php
        $q = mysqli_query($conn,"SELECT * FROM produk");

        while($d = mysqli_fetch_array($q)){
            
        ?>

        <tr>
            <td><?php echo $d['nama']; ?></td>
            <td>Rp<?php echo number_format($d['harga']); ?></td>
            <td><?php echo $d['kategori']; ?></td>
            <td>
                <img src="image/<?php echo $d['gambar']; ?>" width="60">
            </td>
            <td>
                <button class="btn btn-warning btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#editModal<?php echo $d['id']; ?>">
                    Edit
                </button>

                <div class="modal fade" id="editModal<?php echo $d['id']; ?>">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="update_barang.php" method="POST" enctype="multipart/form-data">

                <div class="modal-header">
                    <h5>Edit Barang</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="id" value="<?php echo $d['id']; ?>">

                    <div class="mb-3">
                        <label>Nama Barang</label>
                        <input type="text" name="nama"
                               value="<?php echo $d['nama']; ?>"
                               class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Harga</label>
                        <input type="number" name="harga"
                               value="<?php echo $d['harga']; ?>"
                               class="form-control">
                    </div>

                    <div class="mb-3">
                        
                        <img src="image/<?php echo $d['gambar']; ?>" width="80">
                    </div>

                    <div class="mb-3">
                        <input type="file" name="gambar" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Kategori</label>
                        <input type="text" name="kategori"
                               value="<?php echo $d['kategori']; ?>"
                               class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Update</button>
                </div>

            </form>

        </div>
    </div>
</div>

                <a href="hapus_barang.php?id=<?php echo $d['id']; ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Hapus barang?')">
                    Hapus
                </a>

            </td>
        </tr>

        <?php } ?>

        </tbody>
    </table>

</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal">
    <div class="modal-dialog">
        <div class="modal-content">

        <form action="simpan_barang.php" method="POST" enctype="multipart/form-data">

            <div class="modal-header">
                <h5>Tambah Barang</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label>Nama Barang</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Harga</label>
                    <input type="number" name="harga" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Gambar</label>
                    <input type="file" name="gambar" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Kategori</label>
                    <input type="text" name="kategori" class="form-control" required>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-success">Simpan</button>
            </div>

        </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>