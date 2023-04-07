<div class="mb-4 d-flex justify-content-between">
    <div class="mt-1">
        <p class="mb-2"> Nomor <b> <?= $tagihan['no_tagihan'] ?> </b></p>
        <p class="mb-2"> Tanggal <b> <?= $tagihan['tanggal'] ?> </b></p>
    </div>
    <div class="mt-1 text-right me-4">
        Sisa Tagihan <h5> Rp. <?= number_format($tagihan['sisa_tagihan'], 0, ',', '.'); ?></h5>
    </div>
</div>

<hr>

<div class="table-responsive">
    <table class="table table-hover table-bordered" width="100%" id="tabel">
        <thead style="background-color: #73C6B6;" class="text-center border-secondary">
            <tr>
                <th width="3%">No</th>
                <th width="77%">Nama Rincian</th>
                <th width="20%">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($tagihanRincian as $dt) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $dt['nama_rincian'] ?></td>
                    <td class="text-end pe-4 py-2">Rp. <?= number_format($dt['jumlah'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="fs-5">
                <td colspan="2" class="text-end fw-bold pe-4 py-2">Total</td>
                <td class="text-end fw-bold pe-4 py-2">Rp. <?= number_format($tagihan['jumlah'], 0, ',', '.') ?></td>
            </tr>
        </tbody>
    </table>
</div>