<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Neraca</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>laporan">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="table-responsive">
        <table class="table table-hover" width="100%" id="tabelNeraca">
            <tbody>
                <tr style="background-color: #e6e8fa;">
                    <td>
                        <div class="me-auto mb-1">
                            <h3>Asset</h3>
                        </div>
                    </td>

                    <td class="text-end">
                        <div class="me-2 mb-1">
                            <h4><?= date('d/m/Y') ?></h4>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th width="21%">Kas & Bank</th>
                    <th width="15%"></th>
                </tr>

                <?php foreach ($akunKas as $ak) : ?>
                    <tr>
                        <td><?= $ak['kode'] ?>-<?= $ak['nama']?></td>
                        <td class="text-end"><?= $ak['saldo'] ?></td>
                    </tr>
                <?php endforeach; ?>

                </tr>
                <tr>
                    <td class="fw-bold">Total Kas & Bank</td>
                    <td class="text-end">0</td>
                </tr>

                <tr>
                    <td colspan="2"></td>
                </tr>

                <tr>
                    <th width="21%">Aset Lancar</th>
                    <th width="15%"></th>
                </tr>

                <?php foreach ($akunAktivaLancar as $al) : ?>
                    <tr>
                        <td><?= $al['kode'] ?>-<?= $al['nama']?></td>
                        <td class="text-end"><?= $al['saldo'] ?></td>
                    </tr>
                <?php endforeach; ?>

                <tr>
                    <td class="fw-bold">Total Aset Lancar</td>
                    <td class="text-end">0</td>
                </tr>

                <tr>
                    <td colspan="2"></td>
                </tr>

                <tr>
                    <th width="21%">Aset Tetap</th>
                    <th width="15%"></th>
                </tr>

                <?php foreach ($akunAktivaTetap as $at) : ?>
                    <tr>
                        <td><?= $at['kode'] ?>-<?= $at['nama']?></td>
                        <td class="text-end"><?= $at['saldo'] ?></td>
                    </tr>
                <?php endforeach; ?>

                <tr>
                    <td class="fw-bold">Total Aset Tetap</td>
                    <td class="text-end">0</td>
                </tr>

                <tr>
                    <td colspan="2"></td>
                </tr>

                <tr>
                    <th width="21%">Depresiasi & Amortisasi</th>
                    <th width="15%"></th>
                </tr>
                <tr>
                    
                </tr>
                <tr>
                    <td class="fw-bold">Total Depresiasi & Amortisasi</td>
                    <td class="text-end">0</td>
                </tr>

                <tr>
                    <td colspan="2"></td>
                </tr>

                <tr>
                    <th width="21%">Lainnya</th>
                    <th width="15%"></th>
                </tr>
                <tr>

                </tr>
                <tr>
                    <td class="fw-bold">Total Lainnya</td>
                    <td class="text-end">0</td>
                </tr>

                <tr>
                    <td colspan="2"></td>
                </tr>

                <tr>
                    <td class="fw-bold"><h4>Total Aset</h4></td>
                    <td class="text-end">0</td>
                </tr>

                <tr>
                    <td colspan="2"></td>
                </tr>

                <tr style="background-color: #e6e8fa;">
                    <td>
                        <div class="me-auto mb-1">
                            <h3>Liabilitas and Modal</h3>
                        </div>
                    </td>

                    <td class="text-end">
                        <div class="me-2 mb-1">
                            <h4><?= date('d/m/Y') ?></h4>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th width="21%">Liabilitas Jangka Pendek</th>
                    <th width="15%"></th>
                </tr>
                <tr>

                </tr>
                <tr>
                    <td class="fw-bold">Total Liabilitas Jangka Pendek</td>
                    <td class="text-end">0</td>
                </tr>

                <tr>
                    <td colspan="2"></td>
                </tr>

                <tr>
                    <th width="21%">Liabilitas Jangka Panjang</th>
                    <th width="15%"></th>
                </tr>
                <tr>

                </tr>
                <tr>
                    <td class="fw-bold">Total Liabilitas Jangka Panjang</td>
                    <td class="text-end">0</td>
                </tr>

                <tr>
                    <td colspan="2"></td>
                </tr>

                <tr>
                    <th width="21%">Perubahan Modal</th>
                    <th width="15%"></th>
                </tr>
                <tr>

                </tr>
                <tr>
                    <td class="fw-bold">Total Perubahan Modal</td>
                    <td class="text-end">0</td>
                </tr>

                <tr>
                    <td colspan="2"></td>
                </tr>

                <tr>
                    <td class="fw-bold"><h4>Total Liabilitas and Modal</h4></td>
                    <td class="text-end">0</td>
                </tr>
            </tbody>
        </table>
    </div>


</main>

<?= $this->include('MyLayout/js') ?>
<?= $this->endSection() ?>