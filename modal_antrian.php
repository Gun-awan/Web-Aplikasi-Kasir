<div class="modal fade" id="modal<?php echo $t['id']; ?>">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">

            <div class="modal-header bg-dark text-white rounded-top-4">
                <h5><?php echo $t['customer']; ?></h5>
                <button class="btn-close btn-close-white"
                    data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <?php
                $id = $t['id'];

                $detail = mysqli_query($conn,"
                    SELECT detail_transaksi.*, produk.nama
                    FROM detail_transaksi
                    JOIN produk ON detail_transaksi.produk_id = produk.id
                    WHERE transaksi_id='$id'
                ");

                while($d = mysqli_fetch_array($detail)){
                ?>

                <div class="d-flex justify-content-between border-bottom py-2">
                    <div>
                        <?php echo $d['nama']; ?><br>
                        <small>Qty : <?php echo $d['qty']; ?></small>
                    </div>

                    <div>
                        Rp<?php echo number_format($d['subtotal']); ?>
                    </div>
                </div>

                <?php } ?>

                <div class="mt-3 d-flex justify-content-between">
                    <strong>Total</strong>
                    <strong>Rp<?php echo number_format($t['total']); ?></strong>
                </div>

            </div>

            <div class="modal-footer border-0 d-flex justify-content-between">

                <button class="btn btn-warning rounded-pill"
                    onclick="updateStatus(<?php echo $t['id']; ?>,'pending')">
                    Pending
                </button>

                <button class="btn btn-success rounded-pill"
                    onclick="updateStatus(<?php echo $t['id']; ?>,'selesai')">
                    Selesai
                </button>

                <button class="btn btn-primary rounded-pill"
                    onclick="cetakStruk(<?php echo $t['id']; ?>)">
                    Cetak Struk
                </button>

            </div>

        </div>
    </div>
</div>