<?php

namespace App\Controllers;

use App\Models\JurnalModel;
use App\Models\JurnalDetailModel;
use App\Models\AkunModel;
use CodeIgniter\RESTful\ResourcePresenter;

class JurnalDetail extends ResourcePresenter
{
    public function index()
    {

    }


    public function ListTransaksi($nomor_transaksi)
    {
        // $id_transaksi= $this->request->getVar('id_transaksi');
        $modelAkun   = new AkunModel();
        $akun        = $modelAkun->findAll();
        $modelDetail = new JurnalDetailModel();
        // $detail      = $modelDetail->getDetailJurnal($nomor_tansaksi);
        $modelJurnal = new JurnalModel();

        $data = [
            'transaksi' => $modelJurnal->getJurnal($nomor_tansaksi),
            'akun'      => $akun,
            // 'detail'    => $detail
        ];
        return view('akun/jurnal/detail', $data);
    }


    public function create()
    {
        $id_akun      = $this->request->getPost('id_akun');
        $id_transaksi = $this->request->getPost('id_transaksi');

        $modelAkun = new AkunModel();
        $akun = $modelAkun->find($idAkun);

        $modelJurnalDetail = new JurnalDetailModel();
        
        $data = [
                'id_transaksi'  => $id_transaksi,
                'id_akun'       => $id_akun,
                'deskripsi'     => $this->request->getPost('deskripsi'),
                'debit'         => $this->request->getPost('debit'),
                'kredit'        => $this->request->getPost('kredit')
        ];
        
        $modelJurnalDetail->save($data);

        $json = [
            'notif' => 'Berhasil menambah list produk pemesanan',
        ];

        echo json_encode($json);
    }


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
        $id_transaksi = $this->request->getPost('id_transaksi');
        $modelJurnal = new JurnalModel();
        $no_transaksi = $modelPemesanan->find($id_transaksi)['nomor_transaksi'];

        $modelJurnalDetail = new JurnalDetailModel();

        $modelJurnalDetail->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/list_transaksi/' . $no_transaksi);
    }

    public function check_list_akun()
    {
        $id_transaksi = $this->request->getPost('id_transaksi');
        $modelJurnalDetail = new JurnalDetailModel();
        $akun = $modelJurnalDetail->where(['id_transaksi' => $id_transaksi])->findAll();

        if ($akun) {
            $json = ['ok' => 'ok'];
        } else {
            $json = ['null' => null];
        }
        echo json_encode($json);
    }



}

?>