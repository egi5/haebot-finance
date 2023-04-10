<?php

namespace App\Controllers;

use App\Models\AkunModel;
use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\TagihanModel;
use App\Models\TagihanPembayaranModel;
use App\Models\TagihanRincianModel;
use \Hermawan\DataTables\DataTable;

class Tagihan extends ResourcePresenter
{
    protected $helpers = ['form', 'nomor_auto_helper'];

    public function index()
    {
        return view('tagihan/index');
    }


    public function getDataTagihan()
    {
        if ($this->request->isAJAX()) {

            $modelTagihan = new TagihanModel();
            $data = $modelTagihan->select('id, no_tagihan, id_pembelian, tanggal, status, jumlah, sisa_tagihan')->where('deleted_at', null);

            return DataTable::of($data)
                ->addNumbering('no')
                ->add('aksi', function ($row) {
                    if ($row->status != 'Lunas') {
                        if ($row->id_pembelian == null) {
                            return '
                                <a title="Detail Tagihan" class="px-2 py-0 btn btn-sm btn-outline-dark" onclick="showModalDetail(' . $row->id . ')">
                                    <i class="fa-fw fa-solid fa-magnifying-glass"></i>
                                </a>
                                <a title="Buat Pembayaran" class="px-2 py-0 btn btn-sm btn-outline-primary" href="' . site_url() . 'tagihan/' . $row->id . '/edit">
                                    <i class="fa-fw fa-solid fa-pen"></i>
                                </a>
                                <form id="form_delete" method="POST" class="d-inline">
                                    ' . csrf_field() . '
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>
                                <button onclick="confirm_delete(' . $row->id . ')" title="Hapus Tagihan" type="button" class="px-2 py-0 btn btn-sm btn-outline-danger"><i class="fa-fw fa-solid fa-trash"></i></button>
                                ';
                        } else {
                            return '
                                <a title="Detail Tagihan" class="px-2 py-0 btn btn-sm btn-outline-dark" onclick="showModalDetail(' . $row->id . ')">
                                    <i class="fa-fw fa-solid fa-magnifying-glass"></i>
                                </a>
                                <a title="Buat Pembayaran" class="px-2 py-0 btn btn-sm btn-outline-primary" href="' . site_url() . 'tagihan/' . $row->id . '/edit">
                                    <i class="fa-fw fa-solid fa-pen"></i>
                                </a>
                                ';
                        }
                    } else {
                        return '
                            <a title="Detail Tagihan" class="px-2 py-0 btn btn-sm btn-outline-dark" onclick="showModalDetail(' . $row->id . ')">
                                <i class="fa-fw fa-solid fa-magnifying-glass"></i>
                            </a>';
                    }
                }, 'last')
                ->toJson(true);
        } else {
            return "Tidak bisa load data.";
        }
    }


    public function show($id = null)
    {
        if ($this->request->isAJAX()) {

            $modelTagihan = new TagihanModel();
            $modelTagihanRincian = new TagihanRincianModel();
            $tagihan = $modelTagihan->find($id);
            $tagihanRincian = $modelTagihanRincian->where('id_tagihan', $id)->findAll();

            $data = [
                'tagihan'          => $tagihan,
                'tagihanRincian'   => $tagihanRincian,
            ];

            $json = [
                'data'   => view('tagihan/show', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load data';
        }
    }


    public function new()
    {
        date_default_timezone_set('Asia/Jakarta');
        $modelAkun         = new AkunModel();

        $dariAkun = $modelAkun->where(['id_kategori' => 1])->findAll();

        $data = [
            'dariAkun'            => $dariAkun,
            'nomor_tagihan_auto'  => tagihan_nomor_auto(date('Y-m-d'))
        ];

        return view('tagihan/new', $data);
    }


    public function keAkun()
    {
        $modelAkun  = new AkunModel();
        $dariAkun       = $modelAkun->where(['id_kategori !=' => 1])->orderBy('id_kategori', 'asc')->findAll();

        return $this->response->setJSON($dariAkun);
    }


    public function create()
    {
        // $validasi = [
        //     'nomor_transaksi' => [
        //         'rules'  => 'is_unique[transaksi_jurnal.nomor_transaksi]',
        //         'errors' => [
        //             'is_unique' => 'Nomor sudah ada dalam database. Refresh dan ulangi'
        //         ]
        //     ],
        //     'tanggal'  => [
        //         'rules'  => 'required',
        //         'errors' => [
        //             'required'  => '{field} harus diisi.',
        //         ]
        //     ],
        // ];

        // if (!$this->validate($validasi)) {
        //     $validation = \Config\Services::validation();

        //     $error = [
        //         'error_nomor'   => $validation->getError('nomor_transaksi'),
        //         'error_tanggal' => $validation->getError('tanggal'),
        //     ];

        //     $json = [
        //         'error' => $error
        //     ];
        // } else {
        $modelTagihan           = new TagihanModel();
        $modelRincianTagihan    = new TagihanRincianModel();
        $modelTagihanPembayaran = new TagihanPembayaranModel();
        $modelAkun              = new AkunModel();

        $id_dariakun = $this->request->getPost('id_dariakun');

        // Tagihan
        $data_tagihan = [
            'no_tagihan'        => $this->request->getPost('no_tagihan'),
            'tanggal'           => $this->request->getPost('tanggal'),
            'penerima'          => $this->request->getPost('penerima'),
            'referensi'         => $this->request->getPost('referensi'),
            'status'            => 'Lunas',
            'jumlah'            => $this->request->getPost('total_tagihan')
        ];
        // $modelTagihan->insert($data_tagihan);

        // Pembayaran Tagihan
        $data_pembayaran = [
            // 'id_tagihan'        => $modelTagihan->insertID(),
            'id_user'           => $this->request->getPost('id_user'),
            'tanggal_bayar'     => $this->request->getPost('tanggal'),
            'jumlah'            => $this->request->getPost('total_tagihan')
        ];
        // $modelTagihanPembayaran->insert($data_pembayaran);

        $id_transaksi = $this->modelJurnal->insertID();
        $id_keakun      = $this->request->getPost('id_keakun');
        $deskripsi    = $this->request->getPost('deskripsi');

        for ($i = 0; $i < count($id_keakun); $i++) {
            $akun =
                $data_rincian = [
                    // 'id_tagihan'        => $modelTagihan->insertID(),
                    'nama_rincian'     => $nama_rincian[$i],
                    'jumlah'         => $jumlah[$i],
                ];
            // $modelRincianTagihan->insert($data_rincian);
        }

        // $json = [
        //     'success' => 'Berhasil menambah data jurnal'
        // ];
        // }
        // echo json_encode($json);
    }
}
