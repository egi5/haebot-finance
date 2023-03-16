<?php
$no = 1;
foreach ($akun_transaksi as $at) : ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $at['nomor_transaksi'] ?></td>
        <td><?= $at['akun'] ?></td>
        <td><?= $at['deskripsi']?></td>
        <td>Rp.<?= number_format($at['debit'], 0, ',', '.')?></td>
        <td>Rp.<?= number_format($at['kredit'], 0, ',', '.')?></td>
        <td class="text-center">

            <form id="form_delete" method="POST" class="d-inline">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="id_transaksi" value="<?= $at['id_transaksi'] ?>">
            </form>
            <button onclick="confirm_delete(<?= $at['id'] ?>)" title="Hapus" type="button" class="px-2 py-0 btn btn-sm btn-outline-danger"><i class="fa-fw fa-solid fa-xmark"></i></button>

        </td>
    </tr>
<?php endforeach; ?>

<script>
    function confirm_delete(id) {
        Swal.fire({
            title: 'Konfirmasi?',
            text: "Apakah yakin menghapus produk ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form_delete').attr('action', '<?= site_url() ?>jurnaldetail/' + id);
                $('#form_delete').submit();
            }
        })
    }
</script>