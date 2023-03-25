<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\AkunModel;
use \Hermawan\DataTables\DataTable;

class Neraca extends ResourcePresenter
{
    public function index()
    {
        $modelAkun    = new AkunModel();
        $akunKas      = $modelAkun->where(['id_kategori'=> 1])->findAll();
        $akunPiutang  = $modelAkun->where(['id_kategori'=> 2])->findAll();
        $persediaan   = $modelAkun->where(['id_kategori'=> 3])->findAll();
        $aktivaLancar = $modelAkun->where(['id_kategori'=> 4])->findAll();
        $aktivaTetap  = $modelAkun->where(['id_kategori'=> 5])->findAll();

        $data = [
            'akunKas'           => $akunKas,
            'akunAktivaLancar'  => $aktivaLancar,
            'akunAktivaTetap'   => $aktivaTetap,
        ];
        return view('laporan/neraca/index', $data);
    }

    public function getDataJurnal()
    {
        if ($this->request->isAJAX()) {

            $modelJurnal = new JurnalModel();
            $data = $modelJurnal->select('id, nomor_transaksi, referensi, tanggal, total_transaksi');

            return DataTable::of($data)
                ->addNumbering('no')
                ->add('aksi', function ($row) {
                    return '
                    <a title="Detail" class="px-2 py-0 btn btn-sm btn-outline-dark" onclick="showModalDetail(' . $row->id . ')">
                        <i class="fa-fw fa-solid fa-magnifying-glass"></i>
                    </a>

                    <a title="Edit" class="px-2 py-0 btn btn-sm btn-outline-primary" href="' . site_url() . 'jurnal/' . $row->id . '/edit">
                        <i class="fa-fw fa-solid fa-pen"></i>
                    </a>

                    <form id="form_delete" method="POST" class="d-inline">
                        ' . csrf_field() . '
                        <input type="hidden" name="_method" value="DELETE">
                    </form>
                    <button onclick="confirm_delete(' . $row->id . ')" title="Hapus" type="button" class="px-2 py-0 btn btn-sm btn-outline-danger"><i class="fa-fw fa-solid fa-trash"></i></button>
                    ';
                }, 'last')
                ->toJson(true);
        } else {
            return "Tidak bisa load data.";
        }
    }


    

}

?>