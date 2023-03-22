<?php


function nomor_pemesanan_auto($tgl)
{
    $db = db_connect();

    $quer = "SELECT max(right(no_pemesanan, 2)) AS kode FROM pemesanan WHERE tanggal = '$tgl'";
    $query = $db->query($quer)->getRowArray();

    if ($query) {
        $no = ((int)$query['kode']) + 1;
        $kd = sprintf("%02s", $no);
    } else {
        $kd = "01";
    }
    date_default_timezone_set('Asia/Jakarta');
    $nomor_auto = 'PMS' . date('dmy', strtotime($tgl)) . $kd;

    return $nomor_auto;
}

function jurnal_nomor_auto($tgl)
{
    $db    = db_connect();

    $quer  = "SELECT max(right(nomor_transaksi, 2)) AS nomor FROM transaksi_jurnal WHERE tanggal = '$tgl'";
    $query = $db->query($quer)->getRowArray();

    if($query) {
        $nomor = ((int)$query['nomor']) + 1;
        $kode  = sprintf("%02s", $nomor);
    } else {
        $kode = "01";
    }
    date_default_timezone_set('Asia/Jakarta');
    $nomorAuto = 'MNL' . date('dmy', strtotime($tgl)) . $kode;

    return $nomorAuto;
}
