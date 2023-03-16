<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>

<main class="p-md-3 p-2">
    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Tambah Jurnal</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>jurnalumum">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="col-md-10 mt-4">
        <form autocomplete="off" class="row g-3 mt-3" action="<?= site_url() ?>jurnal/" method="POST" id="form">

            <div class="row mb-3">
                <label for="nama" class="col-sm-3 col-form-label">Nomor Transaksi</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="nomor_transaksi" name="nomor_transaksi" >
                    <div class="invalid-feedback error_nomer"></div>
                </div>
            </div>
                    
            <div class="row mb-3">
                <label for="nama" class="col-sm-3 col-form-label">Tanggal</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>">
                    <div class="invalid-feedback error_tanggal"></div>
                </div>
            </div>

            <div class="row mb-3">
                <label for="satuan" class="col-sm-3 col-form-label">Referensi</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="referensi" name="referensi">
                    <div class="invalid-feedback error_referensi"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-9">

                    <div class="card">
                        <div class="card-header text-light" style="background-color: #3A98B9;">
                            Jurnal Transaksi
                        </div>
                        <div class="card-body" style="background-color: #E6ECF0;">

                            <div class="col-md-8">
                                <div class="input-group mb-3">
                                    <select class="form-select" id="id_akun">
                                        <?php foreach ($akun as $ak) : ?>
                                            <option value="<?= $ak['id'] ?>"><?= $ak['kode']?>-<?= $ak['nama'] ?></option>
                                        <?php endforeach ?>
                                    </select>

                                    <input autocomplete="off" type="text" class="form-control" placeholder="Deskripsi" id="deskripsi">
                                    <input autocomplete="off" type="text" class="form-control" placeholder="Debit" id="debit">
                                    <input autocomplete="off" type="text" class="form-control" placeholder="Kredit" id="kredit">

                                    <button class="btn btn-secondary px-2" type="button" id="tambah_transaksi"><i class="fa-fw fa-solid fa-plus"></i></button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-bordered" width="100%" id="tabel">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="5%">#</th>
                                            <th class="text-center" width="15%">Kode</th>
                                            <th class="text-center" width="20%">Akun</th>
                                            <th class="text-center" width="15%">Deskripsi</th>
                                            <th class="text-center" width="20%">Debit</th>
                                            <th class="text-center" width="20%">Kredit</th>
                                            <th class="text-center" width="5%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabel_list_transaksi">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                
            </div>

            <div class="col-md-9 offset-3 mb-3">
                <button id="tombolSimpan" class="btn px-5 btn-outline-primary" type="submit"><i class="fa-fw fa-solid fa-check"></i>Simpan</button>
            </div>
        </form>
    </div>
</main>

<?= $this->include('MyLayout/js') ?>
<?= $this->include('MyLayout/validation') ?>

<script>
    $('#form').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
                $('#tombolSimpan').html('Tunggu <i class="fa-solid fa-spin fa-spinner"></i>');
                $('#tombolSimpan').prop('disabled', true);
            },
            complete: function() {
                $('#tombolSimpan').html('Lanjutkan <i class="fa-fw fa-solid fa-check"></i>');
                $('#tombolSimpan').prop('disabled', false);
            },
            success: function(response) {
                if (response.error) {
                    let err = response.error;

                    if (err.error_nomor) {
                        $('.error_nomor').html(err.error_nomor);
                        $('#nomor_transaksi').addClass('is-invalid');
                    } else {
                        $('.error_nomor').html('');
                        $('#nomor_transaksi').removeClass('is-invalid');
                        $('#nomor_transaksi').addClass('is-valid');
                    }
                    if (err.error_tanggal) {
                        $('.error_tanggal').html(err.error_tanggal);
                        $('#tanggal').addClass('is-invalid');
                    } else {
                        $('.error_tanggal').html('');
                        $('#tanggal').removeClass('is-invalid');
                        $('#tanggal').addClass('is-valid');
                    }
                    if (err.error_referensi) {
                        $('.error_referensi').html(err.error_referensi);
                        $('#referensi').addClass('is-invalid');
                    } else {
                        $('.error_referensi').html('');
                        $('#referensi').removeClass('is-invalid');
                        $('#referensi').addClass('is-valid');
                    }
                    
                }
                if (response.success) {
                    window.location.replace('<?= base_url() ?>/list_transaksi/' + response.nomor_transaksi);
                }
            },  
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
    })


    $(document).ready(function() {
        $('#tanggal').datepicker({
            format: "yyyy-mm-dd"
        });
    })
</script>

<?= $this->endSection() ?>