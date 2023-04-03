<div>
    <div class="row mb-3">
        <div class="col-md-3">
            <div>
                &nbsp;&nbsp; Nomor Transaksi
            </div>
        </div>
        <div class="col-md-3">
            <div>
                &nbsp;&nbsp; Tanggal
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <h5>&nbsp;&nbsp; <?= $transaksi['nomor_transaksi'] ?></h5>
        </div>
        <div class="col-md-3">
            <h5>&nbsp;&nbsp; <?= $transaksi['tanggal'] ?></h5>
        </div>
    </div>
</div>

<hr>

<div class="table-responsive">
    <table class="table table-hover" width="100%" id="tabel">
        <thead style="background-color: #ebebeb;">
            <tr>
                <th width="20%">Akun</th>
                <th width="17%">Deskripsi</th>
                <th class="text-end pe-4 py-2" width="20%">Debit</th>
                <th class="text-end pe-4 py-2" width="20%">Kredit</th>
            </tr>
        </thead>
        <tbody id="tabel_list_produk">
            <?php
            $no = 1;
            foreach ($detail as $dt) : ?>
                <tr>
                    <td><?= $dt['kode'] ?>-<?= $dt['akun'] ?></td>
                    <td><?= $dt['deskripsi'] ?></td>
                    <td class="text-end pe-4 py-2">Rp. <?= number_format($dt['debit'], 0, ',', '.') ?></td>
                    <td class="text-end pe-4 py-2">Rp. <?= number_format($dt['kredit'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="fs-5">
                <td colspan="2" class="text-end fw-bold pe-4 py-2">Total</td>
                <td class="text-end fw-bold pe-4 py-2">Rp. <?= number_format($transaksi['total_transaksi'], 0, ',', '.') ?></td>
                <td class="text-end fw-bold pe-4 py-2">Rp. <?= number_format($transaksi['total_transaksi'], 0, ',', '.') ?></td>
            </tr>
        </tbody>
    </table>
</div>