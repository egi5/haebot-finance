
        <form autocomplete="off" class="row g-3 mt-3" action="<?= site_url() ?>jurnal/<?= $transaksi['id'] ?>" method="POST" id="form">

            <input type="hidden" name="_method" value="PUT">

            <div class="row mb-3">
                <label for="nama" class="col-sm-3 col-form-label">Nomor Transaksi</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="nomor_transaksi" name="nomor_transaksi" value="<?= $transaksi['nomor_transaksi'] ?>">
                    <div class="invalid-feedback error_nomer"></div>
                </div>
            </div>
                    
            <div class="row mb-3">
                <label for="nama" class="col-sm-3 col-form-label">Tanggal</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="tanggal" name="tanggal" value="<?= $transaksi['tanggal'] ?>">
                    <div class="invalid-feedback error_tanggal"></div>
                </div>
            </div>

            <div class="row mb-3">
                <label for="satuan" class="col-sm-3 col-form-label">Referensi</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="referensi" name="referensi" value="<?= $transaksi['referensi'] ?>">
                    <div class="invalid-feedback error_referensi"></div>
                </div>
            </div>

            <div class="row mb-9">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header text-light" style="background-color: #3A98B9;">
                            Jurnal Transaksi
                        </div>
                        <div class="card-body" style="background-color: #E6ECF0;">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-bordered" width="100%" id="tabel">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="25%">Akun</th>
                                            <th class="text-center" width="30%">Deskripsi</th>
                                            <th class="text-center" width="25%">Debit</th>
                                            <th class="text-center" width="25%">Kredit</th>
                                            <th class="text-center" width="5%">
                                                
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabel_list_transaksi">
                                    <?php $no = 1 ?>
                                    <?php foreach ($detail as $dt) : ?>
                                        <tr>
                                            <td>
                                                <select class="form-control" name="akun[]">
                                                <?php foreach ($akun as $ak) : ?>
                                                    <option <?= (old($dt['id_akun'], $dt['id_akun']) == $ak['id']) ? 'selected' : ''; ?> value="<?= $ak['id'] ?>-krisna-<?= $ak['nama'] ?>"><?= $ak['nama'] ?></option>
                                                <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td><input type="text" class="form-control" id="deskripsi" name="deskripsi" value="<?= $dt['deskripsi'] ?>"></td>
                                            <td><input type="text" class="form-control" id="debit" name="debit" value="<?= $dt['debit'] ?>"></td>
                                            <td><input type="text" class="form-control" id="kredit" name="kredit" value="<?= $dt['kredit'] ?>"></td>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <button class="btn btn-secondary px-2" type="button" id="baris"><i class="fa-fw fa-solid fa-plus"></i></button>
                                <div>
                                    
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="row mt-3 summary">
                                    <div class="col col-md-4" style="text-align: right;">
                                        <span class="title-total">Total</span>
                                    </div>
                                    <div class="col col-md-4" style="text-align: right;">
                                        <span class="title-total">0</span>
                                    </div>
                                    <div class="col col-md-4" style="text-align: right;">
                                        <span class="title-total">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                
            </div>

            <div class="col-md-9 offset-3 mb-3">
                <button id="tombolSimpan" class="btn px-5 btn-outline-primary" type="submit"><i class="fa-fw fa-solid fa-check"></i>Simpan</button>
            </div>
        </form>
    <!-- </div>
</main> -->

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
                $('#tombolSimpan').html('Simpan <i class="fa-fw fa-solid fa-check"></i>');
                $('#tombolSimpan').prop('disabled', false);
            },
            success: function(response) {
                if (response.error) {
                    let err = response.error;

                    if (err.error_nama) {
                        $('.error_nama').html(err.error_nama);
                        $('#nama').addClass('is-invalid');
                    } else {
                        $('.error_nama').html('');
                        $('#nama').removeClass('is-invalid');
                        $('#nama').addClass('is-valid');
                    }
                    if (err.error_deskripsi) {
                        $('.error_deskripsi').html(err.error_deskripsi);
                        $('#deskripsi').addClass('is-invalid');
                    } else {
                        $('.error_deskripsi').html('');
                        $('#deskripsi').removeClass('is-invalid');
                        $('#deskripsi').addClass('is-valid');
                    }
                    if (err.error_debit) {
                        $('.error_debit').html(err.error_debit);
                        $('#debit').addClass('is-invalid');
                    } else {
                        $('.error_debit').html('');
                        $('#debit').removeClass('is-invalid');
                        $('#debit').addClass('is-valid');
                    }
                    
                }
                if (response.success) {
                    $('#my-modal').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: response.success
                    });
                    location.href = "<?= base_url() ?>/kategori";
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
        return false
    })
</script>
