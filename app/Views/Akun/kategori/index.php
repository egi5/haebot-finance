<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Data Kategori Akun</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>listakun">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="mb-1">
            <a class="btn btn-sm btn-outline-secondary mb-3" id="tombolTambah">
                <i class="fa-fw fa-solid fa-plus"></i> Tambah Kategori Akun
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered" width="100%" id="tabel">
            <thead>
                <tr>
                    <th class="text-center" width="5%">No</th>
                    <th class="text-center" width="25%">Nama</th>
                    <th class="text-center" width="15%">Deskripsi</th>
                    <th class="text-center" width="15%">Debit</th>
                    <th class="text-center" width="15%">Kredit</th>
                    <th class="text-center" width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

</main>

<?= $this->include('MyLayout/js') ?>



<!-- Modal -->
<div class="modal fade" id="my-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="judulModal"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="isiForm">

            </div>
        </div>
    </div>
</div>
<!-- Modal -->



<script>
    // Bahan Alert
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        background: '#EC7063',
        color: '#fff',
        iconColor: '#fff',
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    $(document).ready(function() {
        $('#tabel').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?= site_url() ?>getdatakategori',
            order: [],
            columns: [{
                    data: 'no',
                    orderable: false
                },
                {
                    data: 'nama'
                },
                {
                    data: 'deskripsi'
                },
                {
                    data: 'debit'
                },
                {
                    data: 'kredit'
                },
                {
                    data: 'aksi',
                    orderable: false,
                    className: 'text-center'
                },
            ]
        });

        // Alert
        var op = <?= (!empty(session()->getFlashdata('pesan')) ? json_encode(session()->getFlashdata('pesan')) : '""'); ?>;
        if (op != '') {
            Toast.fire({
                icon: 'success',
                title: op
            })
        }
    });


    $('#tombolTambah').click(function(e) {
        e.preventDefault();
        showModalTambah();
    })


    function showModalTambah() {
        $.ajax({
            type: 'GET',
            url: '<?= site_url() ?>kategoriakun/new',
            dataType: 'json',
            success: function(res) {
                if (res.data) {
                    $('#isiForm').html(res.data)
                    $('#my-modal').modal('toggle')
                    $('#judulModal').html('Tambah Kategori')
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        })
    }


    function showModalDetail(id) {
        $.ajax({
            type: 'GET',
            url: '<?= site_url() ?>kategoriakun/' + id,
            dataType: 'json',
            success: function(res) {
                if (res.data) {
                    $('#isiForm').html(res.data)
                    $('#my-modal').modal('toggle')
                    $('#judulModal').html('Detail Kategori Akun')
                } else {
                    console.log(res)
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        })
    }


    function confirm_delete(id) {
        Swal.fire({
            backdrop: false,
            title: 'Konfirmasi?',
            text: "Apakah yakin menghapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form_delete').attr('action', '<?= site_url() ?>kategoriakun/' + id);
                $('#form_delete').submit();
            }
        })
    }


    function showModalEdit(id) {
        $.ajax({
            type: 'GET',
            url: '<?= site_url() ?>kategoriakun/' + id + '/edit',
            dataType: 'json',
            success: function(res) {
                if (res.data) {
                    $('#isiForm').html(res.data)
                    $('#my-modal').modal('toggle')
                    $('#judulModal').html('Edit Kategori Akun')
                } else {
                    console.log(res)
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        })
    }
</script>

<?= $this->endSection() ?>