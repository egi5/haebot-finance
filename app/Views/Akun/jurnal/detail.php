<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Transaksi Jurnal</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>jurnalumum">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

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
                                <option id="id_akun_default" value=""></option>
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
        <div class="col-md-3">

            <div class="card mb-3">
                <div class="card-header text-light" style="background-color: #3A98B9;">
                    Detail Jurnal
                </div>
                <div class="card-body" style="background-color: #E6ECF0;">
                    <form id="form_transaksi" autocomplete="off" action="<?= site_url() ?>simpan_pemesanan" method="post">
                        <input type="hidden" name="id_jurnal" value="<?= $transaksi['id'] ?>">
                        <div class="mb-3">
                            <label for="nomorTransaksi" class="form-label">Nomor Transaksi</label>
                            <input disabled type="text" class="form-control" id="nomorTransaksi" name="nomorTransaksi" value="<?= $transaksi['nomor_transaksi'] ?>">
                        </div>

                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input disabled type="text" class="form-control" id="tanggal" name="tanggal" value="<?= $transaksi['tanggal'] ?>">
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body" style="background-color: #E6ECF0;">
                    <div class="d-grid gap-2">
                        <button class="btn btn-success" id="simpan_jurnal">Simpan Jurnal<i class="fa-solid fa-floppy-disk"></i></button>
                    </div>
                </div>
            </div>

        </div>
    </div>


</main>


<?= $this->include('MyLayout/js') ?>

<script>
    $(document).ready(function() {
        $("#id_akun").select2({
            theme: "bootstrap-5",
            placeholder: 'Akun',
            initSelection: function(element, callback) {}
        });

        $('#tanggal').datepicker({
            format: "yyyy-mm-dd"
        });

        load_list();
    })

    function load_list() {
        let id_transaksi = '<?= $transaksi['id'] ?>'
        $.ajax({
            type: "post",
            url: "<?= base_url() ?>/akun_transaksi",
            data: 'id_transaksi=' + id_transaksi,
            dataType: "json",
            success: function(response) {
                $('#tabel_list_transaksi').html(response.list)
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
    }

    function set_value_select2() {
        $('#id_supplier').val($('#supplier').val());
        $('#id_user').val($('#user').val());
    }

    $('#tambah_transaksi').click(function() {
        let id_akun   = $('#id_akun').val();
        let deskripsi = $('#deskripsi').val();
        let debit = $('#debit').val();
        let kredir = $('#kredit').val();
        let id_transaksi = '<?= $transaksi['id'] ?>'

        if (id_akun != '' && debit != '' && kredit != '') {
            $.ajax({
                type: "post",
                url: "<?= base_url() ?>/create_list_akun",
                data: 'id_transaksi=' + id_transaksi +
                    '&id_akun=' + id_akun +
                    '&deskripsi=' + deskripsi +
                    '&debit=' + debit +
                    '&kredit=' + kredit,
                dataType: "json",
                success: function(response) {
                    if (response.notif) {
                        Swal.fire(
                            'Berhasil',
                            'Berhasil menambah produk ke dalam List',
                            'success'
                        )
                        load_list();
                        $('#deskripsi').val('');
                        $('#debit').val('');
                        $('#kredit').val('');
                        $('#id_akun').val('').trigger('change');
                    } else {
                        alert('terjadi error tambah list produk')
                    }
                },
                error: function(e) {
                    alert('Error \n' + e.responseText);
                }
            });
        } else {
            Swal.fire(
                'Ops.',
                'Pilih Akun dan isi Debit/Kredit dulu.',
                'error'
            )
        }
    })

    $('#simpan_jurnal').click(function() {
        let id_transaksi = '<?= $transaksi['id'] ?>'
        $.ajax({
            type: "post",
            url: "<?= base_url() ?>/check_list_akun",
            data: 'id_transaksi=' + id_transaksi,
            dataType: "json",
            success: function(response) {
                if (response.ok) {
                    Swal.fire({
                        title: 'Konfirmasi?',
                        text: "Apakah yakin menyimpan transaksi ini?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Lanjut!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#form_transaksi').submit();
                        }
                    })
                } else {
                    Swal.fire(
                        'Opss.',
                        'Tidak ada produk dalam pemesanan. pilih minimal satu produk dulu!',
                        'error'
                    )
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
    })
</script>

<?= $this->endSection() ?>