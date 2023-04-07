<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Tagihan</h3>
        </div>
        <div class="mb-1">
            <a class="btn btn-sm btn-outline-secondary" id="tombolTambah">
                <i class="fa-fw fa-solid fa-plus"></i> Tambah Tagihan
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered" width="100%" id="tabel">
            <thead>
                <tr>
                    <th class="text-center" width="4%">No</th>
                    <th class="text-center" width="13%">Tanggal</th>
                    <th class="text-center" width="16%">Nomor</th>
                    <th class="text-center" width="20%">Jumlah Tagihan</th>
                    <th class="text-center" width="20%">Sisa Tagihan</th>
                    <th class="text-center" width="15%">Status</th>
                    <th class="text-center" width="12%">Aksi</th>
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
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="judulModal">Tambah Tagihan</h1>
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
            ajax: '<?= site_url() ?>getDataTagihan',
            order: [],
            columns: [{
                    data: 'no',
                    orderable: false,
                    className: 'text-center'
                },
                {
                    data: 'tanggal',
                    className: 'ps-3'
                },
                {
                    data: 'no_tagihan',
                    className: 'ps-3'
                },
                {
                    data: 'jumlah',
                    render: function(data, type, row) {
                        return 'Rp ' + data.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                    },
                    className: 'ps-3'
                },
                {
                    data: 'sisa_tagihan',
                    render: function(data, type, row) {
                        return 'Rp ' + data.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                    },
                    className: 'ps-3'
                },
                {
                    data: 'status',
                    render: function(data, type, row) {
                        var className = '';
                        if (data === 'Belum dibayar') {
                            className = 'fw-bold text-center text-danger';
                        } else if (data === 'Dibayar Sebagian') {
                            className = 'fw-bold text-center text-warning';
                        } else {
                            className = 'fw-bold text-center text-success';
                        }
                        return '<div class="' + className + '">' + data + '</div>';
                    }
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
        $('#my-modal').modal('toggle');
    })


    function showModalDetail(id) {
        $.ajax({
            type: 'GET',
            url: '<?= site_url() ?>tagihan/' + id,
            dataType: 'json',
            success: function(res) {
                if (res.data) {
                    $('#isiForm').html(res.data)
                    $('#my-modal').modal('toggle')
                    $('#judulModal').html('Detail Rincian Tagihan')
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
                $('#form_delete').attr('action', '<?= site_url() ?>jurnal/' + id);
                $('#form_delete').submit();
            }
        })
    }
</script>

<?= $this->endSection() ?>