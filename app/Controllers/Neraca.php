<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\AkunModel;
use App\Models\JurnalModel;
use \Hermawan\DataTables\DataTable;

class Neraca extends ResourcePresenter
{
    public function index()
    {
        return view('laporan/neraca/index');
    }


    public function getListNeraca(){
        $tglNeraca      = $this->request->getGet('tglNeraca');

        $modelAkun      = new AkunModel();
        $akunKas        = $modelAkun->getAkunKategori(['nama'=> 'Kas & Bank']);
        $akunPiutang    = $modelAkun->getAkunKategori(['nama'=> 'Akun Piutang']);
        $persediaan     = $modelAkun->getAkunKategori(['nama'=> 'Persediaan']);
        $aktivaLancar   = $modelAkun->getAkunKategori(['nama'=> 'Aktiva Lancar']);
        $aktivaTetap    = $modelAkun->getAkunKategori(['nama'=> 'Aktiva Tetap']);
        // dd($akunKas);
        $modelJurnal        = new JurnalModel();
        $saldoAkunKas        = $modelJurnal->getNeraca(['nama'=> 'Kas & Bank']);
        $saldoAkunPiutang   = $modelJurnal->getNeraca(['nama'=> 'Akun Piutang']);
        $saldoPersediaan    = $modelJurnal->getNeraca(['nama'=> 'Persediaan']);
        $saldoAktivaLancar  = $modelJurnal->getNeraca(['nama'=> 'Aktiva Lancar']);
        $saldoAktivaTetap   = $modelJurnal->getNeraca(['nama'=> 'Aktiva Tetap']);
        
        dd($saldoAkunKas);
        
        $data = [
            'akunKas'           => $akunKas,
            'akunAktivaLancar'  => $aktivaLancar,
            'akunAktivaTetap'   => $aktivaTetap,
            // 'depersiasi'        => $depersiasi,
            // 'liabilitasPendek'  => $liabilitasPendek,
            // 'liabilitasPanjang' => $liabilitasPanjang,
        ];

        $json = [
            'data'   => view('laporan/neraca/listNeraca', $data),
        ];

        echo json_encode($json);
    }
}

?>