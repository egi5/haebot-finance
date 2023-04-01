<tr>
    <td colspan="3" class="text-center fw-bold pe-4 py-2">Saldo Awal</td>
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
    if($ba['ktdebit'] == 'Plus'){
        $saldo  += (float)$ba['debit']*1;
    } else {
        $saldo  += (float)$ba['debit']*-1;
    }
    
    if($ba['ktkredit'] == 'Plus'){
        $saldo  += (float)$ba['kredit']*1;
    } else {
        $saldo  += (float)$ba['kredit']*-1;
    }
?>
<tr>
    <td><?= $ba['tanggal'] ?></td>
    <td><?= $ba['nomor'] ?></td>
    <td><?= $ba['referensi'] ?></td>
    <td class="text-end">Rp. <?= number_format($ba['debit'], 0, ',', '.') ?></td>
    <td class="text-end">Rp. <?= number_format($ba['kredit'], 0, ',', '.') ?></td>
    <td class="text-end">Rp. <?= number_format($saldo, 0, ',', '.') ?></td>
</tr>
<?php endforeach; ?>    
            
<tr>
    <td colspan="3" class="text-center fw-bold">Saldo Akhir</td>
    <td class="text-end fw-bold pe-4 py-2">Rp. <?= number_format($totalDebit, 0, ',', '.') ?></td>
    <td class="text-end fw-bold pe-4 py-2">Rp. <?= number_format($totalKredit, 0, ',', '.') ?></td>
    <td class="text-end fw-bold pe-4 py-2">Rp. <?= number_format($saldo, 0, ',', '.') ?></td>
</tr>
<tr>
    <td colspan="3" class="text-end fw-bold pe-4 py-2">Total</td>
    <td class="text-end fw-bold pe-4 py-2">Rp. <?= number_format($totalDebit, 0, ',', '.') ?></td>
    <td class="text-end fw-bold pe-4 py-2">Rp. <?= number_format($totalKredit, 0, ',', '.') ?></td>
</tr>