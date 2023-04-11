<script src="<?= base_url() ?>/template/jquery-3.6.3.min.js"></script>
<script src="<?= base_url() ?>/template/dataTable/datatables.min.js"></script>
<script src="<?= base_url() ?>/template/sweetalert2/sweetalert2.all.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url() ?>/template/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url() ?>/template/js/scripts.js"></script>
<script src="<?= base_url() ?>/template/jquery-mask/jquery.mask.js" crossorigin="anonymous"></script>
<script src="<?= base_url() ?>/template/datepicker/bootstrap-datepicker.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url() ?>/template/select2/js/select2.min.js" crossorigin="anonymous"></script>

<script>
    function formatRupiah(angka) {
        let formattedValue = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(angka).replace(/\D00$/, '');
        return formattedValue;
    }
</script>