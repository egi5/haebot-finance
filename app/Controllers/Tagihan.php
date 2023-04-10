<?php

namespace App\Controllers;

use App\Models\AkunModel;
use App\Models\JurnalDetailModel;
use App\Models\JurnalModel;
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
        $validasi = [
            'no_tagihan' => [
                'rules'  => 'required|is_unique[tagihan.no_tagihan]',
                'errors' => [
                    'required' => 'nomor tagihan belum diisi.',
                    'is_unique' => 'Nomor tagihan sudah ada dalam database. Refresh dan ulangi'
                ]
            ],
            'tanggal'  => [
                'rules'  => 'required',
                'errors' => [
                    'required'  => 'tanggal belum diisi.',
                ]
            ],
            'penerima'  => [
                'rules'  => 'required',
                'errors' => [
                    'required'  => 'penerima belum diisi.',
                ]
            ],
        ];

        if (!$this->validate($validasi)) {
            $validation = \Config\Services::validation();

            $error = [
                'error_nomor'   => $validation->getError('no_tagihan'),
                'error_tanggal' => $validation->getError('tanggal'),
                'error_penerima' => $validation->getError('penerima'),
            ];

            $json = [
                'error' => $error
            ];
        } else {
            $modelTagihan           = new TagihanModel();
            $modelRincianTagihan    = new TagihanRincianModel();
            $modelTagihanPembayaran = new TagihanPembayaranModel();
            $modelAkun              = new AkunModel();


            // Tagihan
            $data_tagihan = [
                'no_tagihan'        => $this->request->getPost('no_tagihan'),
                'tanggal'           => $this->request->getPost('tanggal'),
                'penerima'          => $this->request->getPost('penerima'),
                'referensi'         => $this->request->getPost('referensi'),
                'status'            => 'Lunas',
                'jumlah'            => $this->request->getPost('total_tagihan')
            ];
            $modelTagihan->insert($data_tagihan);
            $id_tagihan = $modelTagihan->insertID();

            // rincian tagihan
            $id_keakun = $this->request->getPost('id_keakun');
            $deskripsi = $this->request->getPost('deskripsi');
            $jumlah_rincian_akun = $this->request->getPost('jumlah_rincian_akun');

            for ($i = 0; $i < count($id_keakun); $i++) {
                $akun = $modelAkun->find($id_keakun[$i]);
                if ($id_keakun[$i] != 0) {
                    $data_rincian = [
                        'id_tagihan'           => $id_tagihan,
                        'id_akun'              => $akun['id'],
                        'nama_rincian'         => $akun['nama'],
                        'deskripsi'            => $deskripsi[$i],
                        'jumlah'               => $jumlah_rincian_akun[$i],
                    ];
                    $modelRincianTagihan->insert($data_rincian);
                }
            }





            // -------------------------------------------------------- PEMBAYARAN TAGIHAN ------------------------------------------------------------------------

            // Pembayaran Tagihan
            $data_pembayaran = [
                'id_tagihan'            => $id_tagihan,
                'id_user'               => $this->request->getPost('id_user'),
                'id_akun_pembayaran'    => $this->request->getPost('id_dariakun'),
                'tanggal_bayar'         => $this->request->getPost('tanggal'),
                'jumlah'                => $this->request->getPost('total_tagihan')
            ];
            $modelTagihanPembayaran->insert($data_pembayaran);





            // ---------------------------------------------------------- JURNAL TRANSAKSI -------------------------------------------------------------------------

            $modelTransaksiJurnal = new JurnalModel();
            $modelTransaksiJurnalDetail = new JurnalDetailModel();

            // input ke jurnal transaksi
            $data_jurnal = [
                'nomor_transaksi'   => nomor_jurnal_auto_tagihan(),
                'referensi'         => $this->request->getVar('no_tagihan') . '-1',
                'tanggal'           => $this->request->getVar('tanggal'),
                'total_transaksi'   => $this->request->getVar('total_tagihan'),
            ];
            $modelTransaksiJurnal->save($data_jurnal);

            // insert detail transaksi jurnal (tagihan)
            for ($i = 0; $i < count($id_keakun); $i++) {
                $akun = $modelAkun->find($id_keakun[$i]);
                if ($id_keakun[$i] != 0) {
                    $data_jurnal_detail = [
                        'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                        'id_akun'           => $akun['id'],
                        'deskripsi'         => $this->request->getVar('no_tagihan') . ' - ' . $akun['nama'],
                        'debit'             => abs($this->isDebit($akun['id'], $jumlah_rincian_akun[$i])),
                        'kredit'            => abs($this->isKredit($akun['id'], $jumlah_rincian_akun[$i])),
                    ];
                    $modelTransaksiJurnalDetail->save($data_jurnal_detail);
                }
            }
            // pembayaran
            $dariakun = $modelAkun->find($this->request->getPost('id_user'));
            $data_jurnal_detail = [
                'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                'id_akun'           => $dariakun['id'],
                'deskripsi'         => $this->request->getVar('no_tagihan') . ' - ' . $dariakun['nama'],
                'debit'             => abs($this->isDebit($dariakun['id'], $this->request->getVar('total_tagihan'))),
                'kredit'            => abs($this->isKredit($dariakun['id'], $this->request->getVar('total_tagihan'))),
            ];
            $modelTransaksiJurnalDetail->save($data_jurnal_detail);


            $json = [
                'success' => 'Berhasil menambah tagihan'
            ];
        }
        echo json_encode($json);
    }


    public function isDebit($id_akun, $value)
    {
        $modelAkun = new AkunModel();
        $akun = $modelAkun->cekKategoriAkun($id_akun);
        if ($akun['debit_is'] == 1) {
            if ($value > 0) {
                return $value;
            } else {
                return 0;
            }
        } else {
            if ($value > 0) {
                return 0;
            } else {
                return $value;
            }
        }
    }

    public function isKredit($id_akun, $value)
    {
        $modelAkun = new AkunModel();
        $akun = $modelAkun->cekKategoriAkun($id_akun);
        if ($akun['debit_is'] == 1) {
            if ($value < 0) {
                return $value;
            } else {
                return 0;
            }
        } else {
            if ($value < 0) {
                return 0;
            } else {
                return $value;
            }
        }
    }
}
