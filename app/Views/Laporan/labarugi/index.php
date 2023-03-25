<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Laba Rugi</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>laporan">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="table-responsive">
        <table class="table table-hover" width="100%" id="tabelLabaRugi">
            <tbody>
                <tr style="background-color: #e6e8fa;">
                    <td>
                        <div class="me-auto mb-1">
                            <h3>Pendapatan</h3>
                        </div>
                    </td>

                    <td class="text-end">
                        <div class="me-2 mb-1">
                            <h4><?= date('d/m/Y') ?></h4>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th width="21%">Penjualan</th>
                    <th width="15%"></th>
                </tr>

                <tr>
                    <td colspan="2"></td>
                </tr>

                <tr>
                    <th width="21%">Penghasilan Lain</th>
                    <th width="15%"></th>
                </tr>

                <tr>
                    <td colspan="2"></td>
                </tr>

                <tr>
                    <td class="fw-bold">Total Pendapatan</td>
                    <td class="text-end">0</td>
                </tr>

                <tr>
                    <td colspan="2"></td>
                </tr>

                <tr style="background-color: #e6e8fa;">
                    <td>
                        <div class="me-auto mb-1">
                            <h3>Beban Pokok Penjualan</h3>
                        </div>
                    </td>

                    <td class="text-end">
                        <div class="me-2 mb-1">
                            <h4><?= date('d/m/Y') ?></h4>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="2"></td>
                </tr>

                <tr>
                    <td class="fw-bold">Total Beban Pokok Penjualan</td>
                    <td class="text-end">0</td>
                </tr>

                <tr>
                    <td colspan="2"></td>
                </tr>

                <tr style="background-color: #e6e8fa;">
                    <td>
                        <div class="me-auto mb-1">
                            <h3>Laba Kotor</h3>
                        </div>
                    </td>

                    <td class="text-end">
                        <div class="me-2 mb-1">
                            <h4>0</h4>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="2"></td>
                </tr>

                <tr style="background-color: #e6e8fa;">
                    <td>
                        <div class="me-auto mb-1">
                            <h3>Biaya Operasional</h3>
                        </div>
                    </td>

                    <td class="text-end">
                        <div class="me-2 mb-1">
                            <h4><?= date('d/m/Y') ?></h4>
                        </div>
                    </td>
                </tr>

                <tr>
                    <th width="21%">Biaya Operasional</th>
                    <th width="15%"></th>
                </tr>

                <tr>
                    <td colspan="2"></td>
                </tr>

                <tr>
                    <th width="21%">Biaya Lain-lain</th>
                    <th width="15%"></th>
                </tr>

                <tr>
                    <td colspan="2"></td>
                </tr>

                <tr>
                    <td class="fw-bold">Total Biaya Operasional</td>
                    <td class="text-end">0</td>
                </tr>

                <tr>
                    <td colspan="2"></td>
                </tr>

                <tr style="background-color: #e6e8fa;">
                    <td>
                        <div class="me-auto mb-1">
                            <h3>Laba Bersih</h3>
                        </div>
                    </td>

                    <td class="text-end">
                        <div class="me-2 mb-1">
                            <h4>0</h4>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>


</main>

<?= $this->include('MyLayout/js') ?>
<?= $this->endSection() ?>