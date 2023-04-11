<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>

<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<main class="p-md-3 p-2">
    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Bayar Tagihan</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>tagihan">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <form autocomplete="off" class="row g-3 mt-3" action="<?= site_url() ?>tagihan/bayar" method="POST" id="form">

        <input type="hidden" id="id_user" name="id_user" value="<?= user()->id ?>">

        <div class="row mb-3">
            <label for="nama" class="col-sm-2 col-form-label">Nomor </label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="no_tagihan" name="no_tagihan" value="<?= $nomor_tagihan_auto ?>">
                <div class="invalid-feedback error_nomor"></div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="nama" class="col-sm-2 col-form-label">Tanggal</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>">
                <div class="invalid-feedback error_tanggal"></div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="satuan" class="col-sm-2 col-form-label">Penerima</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="penerima" name="penerima" value="<?= $tagihan['penerima'] ?>">
                <div class="invalid-feedback error_penerima"></div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="satuan" class="col-sm-2 col-form-label">Referensi</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="referensi" name="referensi" value="<?= $tagihan['referensi'] ?>">
            </div>
        </div>

        <div class="row mb-3">
            <label for="satuan" class="col-sm-2 col-form-label">Dibayar dari</label>
            <div class="col-sm-4">
                <select class="form-select" id="id_dariakun" name="id_dariakun">
                    <?php foreach ($dariAkun as $da) : ?>
                        <option value="<?= $da['id'] ?>"><?= $da['nama'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>

        <div class="container pe-2">

            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered" width="100%" id="tabel">
                    <thead style="background-color: #F6DCA9; border: #566573;">
                        <tr>
                            <th class="text-center" width="35%">Akun</th>
                            <th class="text-center" width="45%">Deskripsi</th>
                            <th class="text-center" width="20%">Total</th>
                        </tr>
                    </thead>
                    <tbody id="list_rincian_tagihan">
                        <tr>
                            <td>
                                <select class="form-select" name="id_keakun" id="id_keakun">
                                    <option value="<?= $keAkun['id'] ?>"><?= $keAkun['nama_akun'] ?></option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="deskripsi" class="form-control" placeholder="Deskripsi" value="<?= $keAkun['deskripsi'] ?>">
                            </td>
                            <td>
                                <input type="number" name="jumlah_rincian_akun" class="form-control text-end jumlah_rincian_akun" id="jumlah_rincian_akun" value="<?= ($keAkun['debit'] == 0) ? $keAkun['kredit'] : (-1 * $keAkun['debit']) ?>">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <div class="row">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless" width="100%">
                        <tr class="fs-4">
                            <td width="47%" class="text-end pe-5 pt-0">Total</td>
                            <td width="53%" class="pt-0" id="text_total_tagihan">Rp. <?= number_format(($keAkun['debit'] == 0) ? $keAkun['kredit'] : (-1 * $keAkun['debit']), 0, ',', '.') ?></td>
                            <input type="hidden" name="total_tagihan" id="total_tagihan">
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-4">
                    <div class="d-grid gap-2 ms-2">
                        <button id="tombolSimpan" class="btn px-5 btn-outline-primary mt-4" type="submit">Simpan <i class="fa-fw fa-solid fa-check"></i></button>
                    </div>
                </div>
            </div>

        </div>


    </form>
</main>

<?= $this->include('MyLayout/js') ?>
<?= $this->include('MyLayout/validation') ?>

<script>
    $(document).ready(function() {
        $('#tanggal').datepicker({
            format: "yyyy-mm-dd"
        });
    })


    $('#form').submit(function(e) {
        e.preventDefault();
        var total_tagihan = $('#total_tagihan').val();
        if (total_tagihan == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Halah..',
                text: 'Total tagihan Rp. 0 lalu apa yamg mau ditagihkan?',
            });
        } else {
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

                        if (err.error_nomor) {
                            $('.error_nomor').html(err.error_nomor);
                            $('#no_tagihan').addClass('is-invalid');
                        } else {
                            $('.error_nomor').html('');
                            $('#no_tagihan').removeClass('is-invalid');
                            $('#no_tagihan').addClass('is-valid');
                        }
                        if (err.error_tanggal) {
                            $('.error_tanggal').html(err.error_tanggal);
                            $('#tanggal').addClass('is-invalid');
                        } else {
                            $('.error_tanggal').html('');
                            $('#tanggal').removeClass('is-invalid');
                            $('#tanggal').addClass('is-valid');
                        }
                        if (err.error_penerima) {
                            $('.error_penerima').html(err.error_penerima);
                            $('#penerima').addClass('is-invalid');
                        } else {
                            $('.error_penerima').html('');
                            $('#penerima').removeClass('is-invalid');
                            $('#penerima').addClass('is-valid');
                        }
                    }
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success,
                        });
                        location.href = "<?= base_url() ?>/tagihan";
                    }
                },
                error: function(e) {
                    alert('Error \n' + e.responseText);
                }
            });
        }
    })
</script>

<?= $this->endSection() ?>