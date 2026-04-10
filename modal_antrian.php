<div class="modal fade" id="modal<?php echo $t['id']; ?>">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">

            <!-- HEADER -->
            <div class="modal-header border-0">

                <div>
                    <h5 class="mb-1"><?php echo $t['customer']; ?></h5>

                    <small class="text-muted d-block">
                        Transaksi #<?php echo $t['id']; ?>
                    </small>

                    <small class="text-muted">
                        <?php echo date('d-m-Y H:i', strtotime($t['tanggal'])); ?>
                    </small>
                </div>

                <button class="btn-close" data-bs-dismiss="modal"></button>

            </div>

            <!-- BODY -->
            <div class="modal-body">

                <?php
                $id = $t['id'];

                $detail = mysqli_query($conn, "
                SELECT detail_transaksi.*, produk.nama
                FROM detail_transaksi
                JOIN produk ON detail_transaksi.produk_id=produk.id
                WHERE transaksi_id='$id'
                ");
                ?>

                <?php while ($d = mysqli_fetch_array($detail)) { ?>

                    <div class="d-flex justify-content-between border-bottom py-2">

                        <div>
                            <strong><?php echo $d['nama']; ?></strong><br>
                            <small class="text-muted">
                                Qty : <?php echo $d['qty']; ?>
                            </small>
                        </div>

                        <div>
                            Rp <?php echo number_format($d['subtotal']); ?>
                        </div>

                    </div>

                <?php } ?>

                <div class="mt-3 text-end">
                    <h5>Total : Rp <?php echo number_format($t['total']); ?></h5>
                </div>

                <hr>

                <div class="mt-3">

                    <label>Bayar</label>
                    <input type="text"
                        class="form-control"
                        id="bayar<?php echo $t['id']; ?>"
                        onkeyup="formatRupiah(this); hitungKembalian(<?php echo $t['id']; ?>, <?php echo $t['total']; ?>)"
                        placeholder="Masukkan nominal bayar">

                </div>

                <div class="mt-3">

                    <?php if ($t['status'] == 'selesai') { ?>

                        <h5>Bayar : Rp <?php echo ($t['bayar']); ?></h5>
                        <h5>Kembalian : Rp <?php echo number_format($t['kembalian']); ?></h5>

                    <?php } else { ?>

                        <h5 id="hasil<?php echo $t['id']; ?>">Kembalian : Rp 0</h5>

                    <?php } ?>

                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer border-0">

                <button class="btn btn-warning"
                    onclick="updateStatus(<?php echo $t['id']; ?>,'pending')">
                    Pending
                </button>

                <a href="hapus_antrian.php?id=<?php echo $t['id']; ?>"
                    class="btn btn-danger"
                    onclick="return confirm('Hapus antrian ini?')">
                    Delete
                </a>

                <button class="btn btn-dark"
                    onclick="cetakStruk(<?php echo $t['id']; ?>)">
                    Cetak Struk
                </button>

                <button class="btn btn-success"
                    onclick="simpanPembayaran(<?php echo $t['id']; ?>, <?php echo $t['total']; ?>)">
                    Selesai
                </button>

            </div>

        </div>
    </div>
</div>
<!-- <script>
    function hitungKembalian(id, total) {

        let bayar = document.getElementById('bayar' + id).value;
        let hasil = document.getElementById('hasil' + id);

        let selisih = bayar - total;

        if (bayar == '') {
            hasil.innerHTML = 'Kembalian : Rp 0';
            return;
        }

        if (selisih >= 0) {
            hasil.innerHTML = 'Kembalian : Rp ' + selisih.toLocaleString();
        } else {
            hasil.innerHTML = 'Sisa kurang : Rp ' + Math.abs(selisih).toLocaleString();
        }
    }
</script> -->
<script>
    function hitungKembalian(id, total) {

        let bayarInput = document.getElementById('bayar' + id).value;

        // HAPUS TITIK
        let bayar = bayarInput.replace(/\./g, '');

        let hasil = document.getElementById('hasil' + id);

        let selisih = bayar - total;

        if (bayar == '') {
            hasil.innerHTML = 'Kembalian : Rp 0';
            return;
        }

        if (selisih >= 0) {
            hasil.innerHTML = 'Kembalian : Rp ' + selisih.toLocaleString();
        } else {
            hasil.innerHTML = 'Sisa kurang : Rp ' + Math.abs(selisih).toLocaleString();
        }
    }
</script>
<!-- Format baru-->
<script>
    function formatRupiah(input) {
        let angka = input.value.replace(/[^,\d]/g, '').toString();
        let split = angka.split(',');
        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        input.value = rupiah;
    }
</script>
<script>
    function simpanPembayaran(id, total) {

        let bayarInput = document.getElementById('bayar' + id).value;

        // hapus titik lalu ubah ke number
        let bayar = parseInt(bayarInput.replace(/\./g, '')) || 0;

        if (bayar === 0) {
            alert('Input bayar dulu');
            return;
        }

        if (bayar < total) {
            alert('Uang bayar kurang');
            return;
        }

        let kembalian = bayar - total;

        window.location.href =
            'update_status.php?id=' + id +
            '&status=selesai' +
            '&bayar=' + bayar +
            '&kembalian=' + kembalian;
    }
</script>