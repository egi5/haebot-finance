<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>

<main class="p-md-3 p-2">
    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Edit Jurnal</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>jurnalumum">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="col-md-10 mt-4">
        <form autocomplete="off" class="row g-3 mt-3" action="<?= site_url() ?>jurnal/<?= $transaksi['id'] ?>" method="POST" id="form">

            <input type="hidden" name="_method" value="PUT">

            <div class="row mb-3">
                <label for="nama" class="col-sm-3 col-form-label">Nomor Transaksi</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="nomor_transaksi" name="nomor_transaksi" value="<?= $transaksi['nomor_transaksi'] ?>" readonly="">
                    <div class="invalid-feedback error_nomer"></div>
                </div>
            </div>
                    
            <div class="row mb-3">
                <label for="nama" class="col-sm-3 col-form-label">Tanggal</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="tanggal" name="tanggal" value="<?= $transaksi['tanggal'] ?>" readonly="">
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
                                    <input type="hidden" id="id_detail" name="id_detail[]" value="<?= $dt['id'] ?>">
                                    <tr>
                                        <td>
                                            <select class="form-control" name="id_akun[]">
                                                <?php foreach ($akun as $ak) : ?>
                                                    <option <?= (old($dt['id_akun'], $dt['id_akun']) == $ak['id']) ? 'selected' : ''; ?> value="<?= $ak['id'] ?>-krisna-<?= $ak['nama'] ?>"><?= $ak['kode'] ?>-<?= $ak['nama'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" id="deskripsi" name="deskripsi[]" value="<?= $dt['deskripsi'] ?>"></td>
                                        <td><input type="text" class="form-control debit" id="debit" name="debit[]" value="<?= $dt['debit'] ?>"></td>
                                        <td><input type="text" class="form-control kredit" id="kredit" name="kredit[]" value="<?= $dt['kredit'] ?>"></td>
                                        <!-- <td><button class='btn px-2 py-0 btn btn-sm btn-outline-danger' id='HapusBaris'><i class='fa-fw fa-solid fa-trash'></i></button></td> -->
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <!-- <button class="btn btn-secondary px-2" type="button" id="baris">Tambah Akun</i></button> -->
                        <div>                
                        </div>
                    </div>

                    <div class="col-md-10">
                        <div class="row mt-3 summary">
                            <div class="col col-md-4" style="text-align: right;">
                                <span class="title-total">Total</span>
                            </div>
                            <div class="col col-md-4" style="text-align: right;">
                                <span class="title-total" name="totalDebit" id="totalDebit">0</span>
                                <input type="hidden" name="total_transaksi" id="total_transaksi">
                            </div>
                            <div class="col col-md-4" style="text-align: right;">
                                <span class="title-total" name="totalKredit" id="totalKredit">0</span>
                                <input type="hidden" name="total_kredit" id="total_kredit">
                            </div>
                        </div>
                        <div class="invalid-feedback error_total"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-9 offset-3 mb-3">
                <button id="tombolSimpan" class="btn px-5 btn-outline-primary" type="submit"><i class="fa-fw fa-solid fa-check"></i>Update</button>
            </div>
        </form>
    </div>
</main>

<?= $this->include('MyLayout/js') ?>
<?= $this->include('MyLayout/validation') ?>

<script>
    function Barisbaru(){
        var Nomor  = $('#tabel tbody tr').length + 1;
        var Baris  = "<tr>";           
            Baris += "<td>";
            Baris += "<select class='form-control' name='id_akun[]' id='id_akun"+Nomor+"' required></select>";
            Baris += "</td>";
            Baris += "<td>";
            Baris += "<input type='text' name='deskripsi[]' class='form-control' placeholder='Deskripsi'>";
            Baris += "</td>";
            Baris += "<td>";
            Baris += "<input type='text' name='debit[]' class='form-control debit' placeholder='Debit'>";
            Baris += "</td>";
            Baris += "<td>";
            Baris += "<input type='text' name='kredit[]' class='form-control kredit' placeholder='Kredit'>";
            Baris += "</td>";
            // Baris += "<td><button class='btn px-2 py-0 btn btn-sm btn-outline-danger' id='HapusBaris'><i class='fa-fw fa-solid fa-trash'></i></button>";
            // Baris += "</td>";
            Baris += "</tr>";

            $('#tabel tbody').append(Baris);

            $('#tabel tbody tr').each(function(){
                $(this).find('td:nth-child(2) input').focus();
            });

            FormSelectAkun(Nomor);
    }


    $(document).ready(function() {
        $('#tanggal').datepicker({
            format: "yyyy-mm-dd"
        });

        hitungDebit();
        hitungKredit();
        
        $('#tabel').on('input','.debit', function(){
            hitungDebit();
        });

        $('#tabel').on('input','.kredit', function(){
            hitungKredit();
        });   
    })


    $('#baris').click(function(e){
        e.preventDefault();

        var A;
        for(A = 1; A <= 1; A++){
            Barisbaru();
        };   
    });


    $(document).on('click','#HapusBaris', function(e){
        e.preventDefault();
        var Nomor = 1;
        $(this).parent().parent().remove();
        $('#table tbody tr').each(function(){
            $(this).find('td:nth-child(1)').html(Nomor);
        })

        hitungDebit();
        hitungKredit();
    })


    function hitungDebit(){
        var totalDebit = 0;
        $('#tabel .debit').each(function(){
            var getValueDebit = $(this).val();
            if ($.isNumeric(getValueDebit)) {
                totalDebit += parseFloat(getValueDebit);
            }                  
        });
        $("#totalDebit").html(totalDebit);
        $("#total_transaksi").val(totalDebit);
    }


    function hitungKredit(){
        var totalKredit = 0;
        $('#tabel .kredit').each(function(){
            var getValueKredit = $(this).val();
            if ($.isNumeric(getValueKredit)) {
                totalKredit += parseFloat(getValueKredit);
            }                  
        });
        $("#totalKredit").html(totalKredit);
        $("#total_kredit").val(totalKredit);
    }


    function FormSelectAkun(Nomor){
        var output = [];
        output.push('<option value ="">Pilih Akun</option>');
        $.getJSON('/Jurnal/akun', function(data){
            $.each(data, function(key, value){
                output.push('<option value="'+ value.id+'">'+ value.kode +'-'+ value.nama +'</option>');
            });
            $('#id_akun'+ Nomor).html(output.join(''));
        });
    }

    // $('#form').submit(function(e) {
    //     e.preventDefault();
        
    //     $.ajax({
    //         type: "post",
    //         url: $(this).attr('action'),
    //         data: $(this).serialize(),
    //         dataType: "json",
    //         beforeSend: function() {
    //             $('#tombolSimpan').html('Tunggu <i class="fa-solid fa-spin fa-spinner"></i>');
    //             $('#tombolSimpan').prop('disabled', true);
    //         },
    //         complete: function() {
    //             $('#tombolSimpan').html('Simpan <i class="fa-fw fa-solid fa-check"></i>');
    //             $('#tombolSimpan').prop('disabled', false);
    //         },
    //         success: function(response) {
    //             if (response.error) {
    //                 let err = response.error;

    //                 if (err.error_nama) {
    //                     $('.error_nama').html(err.error_nama);
    //                     $('#nama').addClass('is-invalid');
    //                 } else {
    //                     $('.error_nama').html('');
    //                     $('#nama').removeClass('is-invalid');
    //                     $('#nama').addClass('is-valid');
    //                 }
    //                 if (err.error_deskripsi) {
    //                     $('.error_deskripsi').html(err.error_deskripsi);
    //                     $('#deskripsi').addClass('is-invalid');
    //                 } else {
    //                     $('.error_deskripsi').html('');
    //                     $('#deskripsi').removeClass('is-invalid');
    //                     $('#deskripsi').addClass('is-valid');
    //                 }
    //                 if (err.error_debit) {
    //                     $('.error_debit').html(err.error_debit);
    //                     $('#debit').addClass('is-invalid');
    //                 } else {
    //                     $('.error_debit').html('');
    //                     $('#debit').removeClass('is-invalid');
    //                     $('#debit').addClass('is-valid');
    //                 }
                    
    //             }
    //             if (response.success) {
    //                 $('#my-modal').modal('hide');
    //                 Toast.fire({
    //                     icon: 'success',
    //                     title: response.success
    //                 });
    //                 location.href = "<?= base_url() ?>/kategori";
    //             }
    //         },
    //         error: function(e) {
    //             alert('Errorssssss \n' + e.responseText);
    //         }
    //     });
    //     return false
    // })
</script>
<?= $this->endSection() ?>
