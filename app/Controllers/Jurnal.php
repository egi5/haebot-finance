<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\JurnalModel;
use App\Models\JurnalDetailModel;
use App\Models\AkunModel;
use \Hermawan\DataTables\DataTable;

class Jurnal extends ResourcePresenter
{
    protected $helpers = ['form', 'nomor_auto_helper'];

    function __construct()
    {
        $this->db                = \Config\Database::connect();
        $this->modelJurnal       = new JurnalModel();
        $this->modelJurnalDetail = new JurnalDetailModel();
    }

    public function index()
    {
        return view('akun/jurnal/index');
    }

    public function getDataJurnal()
    {
        // if ($this->request->isAJAX()) {

            $modelJurnal = new JurnalModel();
            $data = $modelJurnal->select('id, nomor_transaksi, referensi, tanggal, total_transaksi');

            return DataTable::of($data)
                ->addNumbering('no')
                ->add('aksi', function ($row) {
                    return '
                    <a title="Detail" class="px-2 py-0 btn btn-sm btn-outline-dark" onclick="showModalDetail(' . $row->id . ')">
                        <i class="fa-fw fa-solid fa-magnifying-glass"></i>
                    </a>

                    <a title="Edit" class="px-2 py-0 btn btn-sm btn-outline-primary" onclick="showModalEdit(' . $row->id . ')">
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
        // } else {
        //     return "Tidak bisa load data.";
        // }
    }


    public function show($id = null)
    {
        // if ($this->request->isAJAX()) {

            $modelAkun         = new AkunModel();
            $modelJurnal       = new JurnalModel();
            $modelJurnalDetail = new JurnalDetailModel();
            $akun              = $modelAkun->findAll();
            $detail            = $modelJurnalDetail->findAll();
            $transaksi         = $modelJurnal->find($id);

            $data = [
                'akun'          => $akun,
                'detail'        => $detail,
                'transaksi'     => $transaksi,
            ];


            $json = [
                'data'   => view('akun/jurnal/show', $data),
            ];

            echo json_encode($json);
        // } else {
        //     return 'Tidak bisa load data';
        // }
    }


    public function new()
    {
        date_default_timezone_set('Asia/Jakarta');
        $modelAkun         = new AkunModel();
        $modelJurnal       = new JurnalModel();
        $modelJurnalDetail = new JurnalDetailModel();

        $akun = $modelAkun->findAll();

        $data = [
            'akun'                  => $akun,
            'nomor_transaksi_auto'  => date('Y-m-d')
        ];

        return view('akun/jurnal/add', $data);
    }


    public function create()
    {
       
        $modelAkun         = new AkunModel();
        $modelJurnal       = new JurnalModel();
        $modelJurnalDetail = new JurnalDetailModel();

        $data = [
            'nomor_transaksi'   => $this->request->getPost('nomor_transaksi'),    
            'tanggal'           => $this->request->getPost('tanggal'),
            'referensi'         => $this->request->getPost('referensi')
        ];
        $modelJurnal->insert($data);

        $id_transaksi = $this->modelJurnal->insertID();
        $id_akun      = $this->request->getPost('id_akun');
        $deskripsi    = $this->request->getPost('deskripsi');
        $debit        = $this->request->getPost('debit');
        $kredit       = $this->request->getPost('kredit');

        for ($i=0; $i < count($id_akun) ; $i++) { 
            $dataAkun = [
                'id_transaksi'  => $id_transaksi,
                'id_akun'       => $id_akun[$i],
                'deskripsi'     => $deskripsi[$i],
                'debit'         => $debit[$i],
                'kredit'        => $kredit[$i]
            ];
            $modelJurnalDetail->insert($dataAkun);
        }
    }


    public function akun()
    {
        $modelAkun  = new AkunModel();
        $akun       = $modelAkun->findAll();

        return $this->response->setJSON($akun);
    }


    public function edit($id = null)
    {
        // if ($this->request->isAJAX()) {
            
            $modelAkun         = new AkunModel();
            $modelJurnal       = new JurnalModel();
            $modelJurnalDetail = new JurnalDetailModel();
            $akun              = $modelAkun->findAll();
            $detail            = $modelJurnalDetail->findAll();
            $transaksi         = $modelJurnal->find($id);

            $data = [
                'validation'    => \Config\Services::validation(),
                'akun'          => $akun,
                'detail'        => $detail,
                'transaksi'     => $transaksi,
            ];

            $json = [
                'data'   => view('akun/jurnal/edit', $data),
            ];

            echo json_encode($json);
        // } else {
        //     return 'Tidak bisa load data';
        // }
    }


    // public function create()
    // {
    //     if ($this->request->isAJAX()) {
    //         $validasi = [
    //             'nomor_transaksi' => [
    //                 'rules' => 'required',
    //                 'errors' => [
    //                     'required' => 'Nomor jurnal harus diisi.',
    //                     // 'is_unique' => 'Nomor jurnal sudah ada dalam database.'
    //                 ]
    //             ],
    //             'tanggal' => [
    //                 'rules' => 'required',
    //                 'errors' => [
    //                     'required' => 'tanggal pemesanan harus diisi.',
    //                 ]
    //             ],
    //             'referensi' => [
    //                 'rules' => 'required',
    //                 'errors' => [
    //                     'required' => 'harap isi referensi',
    //                 ]
    //             ],
    //         ];

    //         if (!$this->validate($validasi)) {
    //             $validation = \Config\Services::validation();

    //             $error = [
    //                 'error_nomor'       => $validation->getError('nomor_transaksi'),
    //                 'error_tanggal'     => $validation->getError('tanggal'),
    //                 'error_referensi'   => $validation->getError('referensi'),
    //             ];

    //             $json = [
    //                 'error' => $error
    //             ];
    //         } else {
    //             $modelJurnal = new JurnalModel();

    //             $data = [
    //                 'nomor_transaksi'   => $this->request->getPost('nomor_transaksi'),
    //                 'tanggal'           => $this->request->getPost('tanggal'),
    //                 'referensi'         => $this->request->getPost('referensi'),
    //                 'total'             => $this->request->getPost('total_transaksi'),
    //             ];

    //             $modelJurnal->save($data);

    //             $json = [
    //                 'success'           => 'Berhasil menambah jurnal transaksi',
    //                 'nomor_transaksi'   => $this->request->getPost('nomor_transaksi')
    //             ];
    //         }

    //         echo json_encode($json);
    //     } else {
    //         return 'Tidak bisa load';
    //     }
    // }


    public function getListAkunTransaksi()
    {
        if ($this->request->isAJAX()) {

            $id_transaksi = $this->request->getVar('id_transaksi');

            $modelJurnalDetail = new JurnalDetailModel();
            $akun_transaksi = $modelJurnalDetail->getJurnaldETAIL($id_transaksi);

            if ($akun_transaksi) {
                $data = [
                    'akun_transaksi'      => $akun_transaksi,
                ];

                $json = [
                    'list' => view('akun/jurnal/list_transaksi', $data),
                ];
            } else {
                $json = [
                    'list' => '<tr><td colspan="7" class="text-center">Belum ada list Produk.</td></tr>',
                ];
            }

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function delete($id = null)
    {
        $modelJurnal = new JurnalModel();

        $modelJurnal->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/jurnal');
    }
}

?>