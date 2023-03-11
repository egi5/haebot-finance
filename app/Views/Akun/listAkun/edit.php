<form autocomplete="off" class="row g-3 mt-3" action="<?= site_url() ?>akun/<?= $akun['id'] ?>" method="POST" id="form">

    <?= csrf_field() ?>

    <input type="hidden" name="_method" value="PUT">

    <div class="row mb-3">
        <label for="nama" class="col-sm-3 col-form-label">Kode Akun</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="kode" name="kode" value="<?= $akun['kode'] ?>">
            <div class="invalid-feedback error_nama"></div>
        </div>
    </div>

    <div class="row mb-3">
        <label for="nama" class="col-sm-3 col-form-label">Nama Akun</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="nama" name="nama" value="<?= $akun['nama']?>">
            <div class="invalid-feedback error_nama"></div>
        </div>
    </div>

    <div class="row mb-3">
        <label for="deskripsi" class="col-sm-3 col-form-label">Kategori Akun</label>
        <div class="col-sm-9">
            <select class="form-control" name="id_kategori" id="id_kategori">
                <?php foreach ($kategori as $kt) : ?>
                    <option <?= (old('id_kategori', $akun['id_kategori']) == $kt['id']) ? 'selected' : ''; ?> value="<?= $kt['id'] ?>-krisna-<?= $kt['nama'] ?>"><?= $kt['nama'] ?></option>
                <?php endforeach ?>
            </select>

        </div>
    </div>

    <div class="text-center">
        <a class="btn px-5 btn-outline-danger" href="<?= site_url() ?>/listakun">Batal 
            <i class="fa-fw fa-solid fa-xmark"></i>
        </a>
        <button id="#tombolUpdate" class="btn px-5 btn-outline-primary" type="submit">Update<i class="fa-fw fa-solid fa-check"></i></button>
    </div>
</form>

<?= $this->include('MyLayout/js') ?>

<script>
    $(document).ready(function() 
    {
        // Alert
        var op = <?= (!empty(session()->getFlashdata('pesan')) ? json_encode(session()->getFlashdata('pesan')) : '""'); ?>;
        if (op != '') {
            Toast.fire({
                icon: 'success',
                title: op
            })
        }

        // Bahan Alert
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            background: '#63ec88',
            color: '#fff',
            iconColor: '#fff',
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
    })

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
                    
                }
                if (response.success) {
                    $('#my-modal').modal('hide')
                    $('#tabel').DataTable().ajax.reload();
                    Toast.fire({
                        icon: 'success',
                        title: response.success
                    })
                    return redirect()->to('/divisi');
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
        return false
    })
    
</script>