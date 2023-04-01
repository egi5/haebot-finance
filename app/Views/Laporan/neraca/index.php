<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Neraca</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>laporan">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="row justify-content-end">
        <div class="col-sm-2">
            <input type="text" class="form-control" id="tglNeraca" name="tglNeraca" value="<?= date('Y-m-d') ?>">
            <br>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover" width="100%" id="tabelNeraca">
            <tbody id="tabelListNeraca">
                
            </tbody>
        </table>
    </div>
</main>

<?= $this->include('MyLayout/js') ?>

<script>
    $(document).ready(function() {
        $('#tglNeraca').datepicker({
            format: "yyyy-mm-dd"
        });

        var tglNeraca  = $('#tglNeraca').val();
        $.ajax({
            type: 'GET',
            url: '<?= site_url() ?>/listNeraca',
            data: 'tglNeraca=' + tglNeraca,
            dataType: "json",
            success: function(response) {
                if(response.data){
                    $('#tabelListNeraca').html(response.data);
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
    })
</script>
<?= $this->endSection() ?>