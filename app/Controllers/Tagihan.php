<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\TagihanModel;
use App\Models\TagihanRincianModel;
use \Hermawan\DataTables\DataTable;

class Tagihan extends ResourcePresenter
{

    public function index()
    {
        return view('tagihan/index');
    }


    public function getDataTagihan()
    {
        // if ($this->request->isAJAX()) {

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
        // } else {
        //     return "Tidak bisa load data.";
        // }
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
}
