<?= $this->include('MyLayout/css') ?>
<div>
    <div class="row mb-3">
        <div class="fw-bold">
            <h3>Transaksi <?= $akun['nama'] ?></h3>
        </div>
        <div class="fw-bold">
            <h4><?= $akun['kode'] ?></h4>
        </div>
    </div>
</div>

<hr>

<form autocomplete="off" class="row g-3 mt-3" method="POST" id="form">
<input type="hidden" class="form-control" id="idAkun" value="<?= $akun['id'] ?>">
<div class="row justify-content-end">
    <div class="col-sm-2">
        <input type="text" class="form-control" id="tglAwal" name="tglAwal" value="<?= $tglAwal ?>">
    </div>
    <!-- <div>
        <i class="fa-solid fa-repeat" style="color: #bfd6fd;"></i>
    </div> -->
    <div class="col-sm-2">
        <input type="text" class="form-control" id="tglAkhir" name="tglAkhir" value="<?= $tglAkhir ?>">
    </div>
</div>
</from>

<div class="table-responsive">
    <table class="table table-sm table-bordered" width="100%" id="tabelBuku">
        <thead>
            <tr>
                <th class="text-center" width="15%">Tanggal</th>
                <th class="text-center" width="15%">Nomor</th>
                <th class="text-center" width="15%">Reference</th>
                <th class="text-center" width="15%">Debit</th>
                <th class="text-center" width="15%">Kredit</th>
                <th class="text-center" width="15%">Saldo Berjalan</th>
            </tr>
        </thead>
        <tbody id="tabelBukuBesar">
            
        </tbody>
    </table>
</div>
<?= $this->include('MyLayout/js') ?>
<script>
    $(document).ready(function() {
        $('#tglAwal').datepicker({
            format: "yyyy-mm-dd"
        });
        $('#tglAkhir').datepicker({
            format: "yyyy-mm-dd"
        });

        var idAkun   = $('#idAkun').val();
        var tglAwal  = $('#tglAwal').val();
        var tglAkhir = $('#tglAkhir').val();
        $.ajax({
            type: 'GET',
            url: '<?= site_url() ?>/listBuku',
            data: 'idAkun=' + idAkun +
                  '&tglAwal=' + tglAwal +
                  '&tglAkhir=' + tglAkhir,
            dataType: "json",
            success: function(response) {
                if(response.data){
                    $('#tabelBukuBesar').html(response.data);
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
     })
</script>