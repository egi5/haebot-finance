<tr>
    <td colspan="3">
        <h6 class="my-0">Saldo Awal</h6>
    </td>
    <td class="text-end pe-4 py-2"></td>
    <td class="text-end pe-4 py-2"></td>
    <td class="text-end pe-4 py-2"></td>
</tr>

<?php
$saldo       = 0;
$totalDebit  = 0;
$totalKredit = 0;
?>

<?php foreach ($bukuAkun as $ba) : ?>
    <?=
    $totalDebit  += $ba['debit'];
    $totalKredit += $ba['kredit'];

    $saldo  += (float)$ba['debit'] * (float)$ba['ktdebit'];
    $saldo  += (float)$ba['kredit'] * (float)$ba['ktkredit'];
    ?>
    <tr>
        <td><?= $ba['tanggal'] ?></td>
        <td><?= $ba['nomor'] ?></td>
        <td><?= $ba['referensi'] ?></td>
        <td class="text-end pe-4 py-2">Rp. <?= number_format($ba['debit'], 0, ',', '.') ?></td>
        <td class="text-end pe-4 py-2">Rp. <?= number_format($ba['kredit'], 0, ',', '.') ?></td>
        <td class="text-end pe-4 py-2">Rp. <?= number_format($saldo, 0, ',', '.') ?></td>
    </tr>
<?php endforeach; ?>

<tr>
    <td colspan="3">
        <h6 class="my-0">Saldo Akhir</h6>
    </td>
    <td class="text-end fw-bold pe-4 py-2">Rp. <?= number_format($totalDebit, 0, ',', '.') ?></td>
    <td class="text-end fw-bold pe-4 py-2">Rp. <?= number_format($totalKredit, 0, ',', '.') ?></td>
    <td class="text-end fw-bold pe-4 py-2">Rp. <?= number_format($saldo, 0, ',', '.') ?></td>
</tr>
<tr>
    <td colspan="3">
        <h6>Total</h6>
    </td>
    <td class="text-end fw-bold pe-4 py-2">Rp. <?= number_format($totalDebit, 0, ',', '.') ?></td>
    <td class="text-end fw-bold pe-4 py-2">Rp. <?= number_format($totalKredit, 0, ',', '.') ?></td>
    <td class="text-end fw-bold pe-4 py-2"></td>
</tr>