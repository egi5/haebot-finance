<div>
    <div class="row mb-3">
        <div class="col-md-3">
            <div class="fw-bold">
                &nbsp;&nbsp; Kode
            </div>
        </div>
        <div class="col-md-9">
            <?= $akun['kode'] ?>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <div class="fw-bold">
                &nbsp;&nbsp; Nama
            </div>
        </div>
        <div class="col-md-9">
            <?= $akun['nama'] ?>
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="col-md-3">
            <div class="fw-bold">
                &nbsp;&nbsp; Nama Kategori Akun
            </div>
        </div>
        <div class="col-md-9">
            <?= $kategori['nama'] ?>
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="col-md-3">
            <div class="fw-bold">
                &nbsp;&nbsp; Debit/Kredit Akun
            </div>
        </div>
        <div class="col-md-9">
            <?= $kategori['debit_kredit'] ?>
        </div>
    </div>
</div>

<hr>

<div class="table-responsive">
    <table class="table table-sm table-bordered" width="100%" id="tabel">
        <thead>
            <tr>
                <th class="text-center" width="15%">Tanggal</th>
                <th class="text-center" width="15%">Sumber</th>
                <th class="text-center" width="15%">Nomor</th>
                <th class="text-center" width="15%">Debit</th>
                <th class="text-center" width="15%">Kredit</th>
                <th class="text-center" width="15%">Saldo Berjalan</th>
            </tr>
        </thead>
        <tbody id="tabelAkun">
            <tr>
                <td class="text-end fw-bold pe-4 py-2">Saldo Awal</td>
                <td></td>
                <td></td>
                <td class="text-end pe-4 py-2">0</td>
                <td class="text-end pe-4 py-2">0</td>
                <td class="text-end pe-4 py-2">0</td>
            </tr>
            <tr>
                <td class="text-end fw-bold pe-4 py-2">Saldo Akhir</td>
                <td></td>
                <td></td>
                <td class="text-end fw-bold pe-4 py-2">0</td>
                <td class="text-end fw-bold pe-4 py-2">0</td>
                <td class="text-end fw-bold pe-4 py-2">0</td>
            </tr>
            <tr>
                <td colspan="3" class="text-end fw-bold pe-4 py-2">Total</td>
                <td class="text-end fw-bold pe-4 py-2">0</td>
                <td class="text-end fw-bold pe-4 py-2">0</td>
                <td class="text-end fw-bold pe-4 py-2">0</td>
            </tr>
        </tbody>
    </table>
</div>