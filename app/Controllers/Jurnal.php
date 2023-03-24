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


    public function show($id = null)
    {
        // if ($this->request->isAJAX()) {

            $modelAkun         = new AkunModel();
            $modelJurnal       = new JurnalModel();
            $modelJurnalDetail = new JurnalDetailModel();
            $transaksi         = $modelJurnal->find($id);
            $akun              = $modelAkun->findAll();
            $detail            = $modelJurnalDetail->where(['id_transaksi'=> $transaksi['id']])->findAll();
            

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
            'akun'               => $akun,
            'nomor_jurnal_auto'  => jurnal_nomor_auto(date('Y-m-d'))
        ];
        
        return view('akun/jurnal/add', $data);
    }


    public function create()
    {
        $validasi = [
            'nomor_transaksi' => [
                'rules'  => 'is_unique[transaksi_jurnal.nomor_transaksi]',
                'errors' => [
                    'is_unique' => 'Nomor sudah ada dalam database. Refresh dan ulangi'
                ]
            ],
        ];

        $totaldebit        = $this->request->getPost('total_transaksi');
        $totalkredit       = $this->request->getPost('total_kredit');

        if (!$this->validate($validasi) ) {
            $validation = \Config\Services::validation();

            $error = [
                'error_nomor'   => $validation->getError('nomor_transaksi'),
                // 'error_total'   => 'Debit dan Kredit harus bernilai sama'
            ];

            $json = [
                'error' => $error
            ];

            
        } else {
            $modelAkun         = new AkunModel();
            $modelJurnal       = new JurnalModel();
            $modelJurnalDetail = new JurnalDetailModel();

            $data = [
                'nomor_transaksi'   => $this->request->getPost('nomor_transaksi'),    
                'tanggal'           => $this->request->getPost('tanggal'),
                'referensi'         => $this->request->getPost('referensi'),
                'total_transaksi'   => $this->request->getPost('total_transaksi')
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

            $json = [
                'success' => 'Berhasil menambah data produk'
            ];

        }
        echo json_encode($json);
        
    }


    public function akun()
    {
        $modelAkun  = new AkunModel();
        $akun       = $modelAkun->findAll();

        return $this->response->setJSON($akun);
    }


    public function edit($id = null)
    {       
        $modelAkun         = new AkunModel();
        $modelJurnal       = new JurnalModel();
        $modelJurnalDetail = new JurnalDetailModel();
        $transaksi         = $modelJurnal->find($id);
        $detail            = $modelJurnalDetail->where(['id_transaksi'=> $transaksi['id']])->findAll();
        $akun              = $modelAkun->findAll();
            
            
        $data = [
            'validation'    => \Config\Services::validation(),
            'akun'          => $akun,
            'detail'        => $detail,
            'transaksi'     => $transaksi,
        ];

        return view('akun/jurnal/edit', $data);
    }
    
    
    public function update($id = null)
    {
        $modelAkun         = new AkunModel();
        $modelJurnal       = new JurnalModel();
        $modelJurnalDetail = new JurnalDetailModel();

        $data = [
            'id'                => $id,
            'nomor_transaksi'   => $this->request->getPost('nomor_transaksi'),    
            'tanggal'           => $this->request->getPost('tanggal'),
            'referensi'         => $this->request->getPost('referensi'),
            'total_transaksi'   => $this->request->getPost('total_transaksi')
        ];
        $modelJurnal->save($data);

        $id_detail    = $this->request->getPost('id_detail');
        $id_akun      = $this->request->getPost('id_akun');
        $deskripsi    = $this->request->getPost('deskripsi');
        $debit        = $this->request->getPost('debit');
        $kredit       = $this->request->getPost('kredit');

        for($i=0; $i < count($id_akun) ; $i++) { 
            $dataAkun = [
                'id'            => $id_detail[$i],
                'id_akun'       => $id_akun[$i],
                'deskripsi'     => $deskripsi[$i],
                'debit'         => $debit[$i],
                'kredit'        => $kredit[$i]
            ];
            $modelJurnalDetail->save($dataAkun);
        }

        session()->setFlashdata('pesan', 'Data berhasil diupdate.');

        return redirect()->to('/jurnal');
    }


    public function delete($id = null)
    {
        $modelJurnal        = new JurnalModel();
        // $modelJurnalDetail  = New JurnalDetailModel();
        // $modelJurnalDetail->where(['id_transaksi' =>$id])->delete();
        $modelJurnal->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/jurnal');
    }
}

?>