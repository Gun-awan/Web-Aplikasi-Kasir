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

                $detail = mysqli_query($conn,"
                SELECT detail_transaksi.*, produk.nama
                FROM detail_transaksi
                JOIN produk ON detail_transaksi.produk_id=produk.id
                WHERE transaksi_id='$id'
                ");
                ?>

                <?php while($d = mysqli_fetch_array($detail)){ ?>

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
                    onclick="updateStatus(<?php echo $t['id']; ?>,'selesai')">
                    Selesai
                </button>

            </div>

        </div>
    </div>
</div>