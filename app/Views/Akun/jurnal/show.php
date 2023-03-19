<div>
    <div class="row mb-3">
        <div class="col-md-3">
            <div class="fw-bold">
                &nbsp;&nbsp; Nomor Transaksi
            </div>
        </div>
        <div class="col-md-9">
            <?= $transaksi['nomor_transaksi'] ?>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <div class="fw-bold">
                &nbsp;&nbsp; Tanggal
            </div>
        </div>
        <div class="col-md-9">
            <?= $transaksi['tanggal'] ?>
        </div>
    </div>
</div>

<hr>

<div class="table-responsive">
    <table class="table table-sm table-bordered" width="100%" id="tabel">
        <thead>
            <tr>
                <th class="text-center" width="20%">Akun</th>
                <th class="text-center" width="20%">Deskripsi</th>
                <th class="text-center" width="20%">Debit</th>
                <th class="text-center" width="20%">Kredit</th>
            </tr>
        </thead>
        <tbody id="tabel_list_produk">
            <?php
            $no = 1;
            foreach ($detail as $dt) : ?>
                <tr>
                    <td><?= $dt['id_akun'] ?></td>
                    <td><?= $dt['deskripsi'] ?></td>
                    <td>Rp. <?= number_format($dt['debit'], 0, ',', '.') ?></td>
                    <td>Rp. <?= number_format($dt['kredit'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="fs-5">
                <td colspan="5" class="text-end fw-bold pe-4 py-2">Total</td>
            </tr>
        </tbody>
    </table>
</div>