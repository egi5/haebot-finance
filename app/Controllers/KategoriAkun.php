<?php

namespace App\Controllers;
use App\Models\KategoriAkunModel;
use CodeIgniter\RESTful\ResourcePresenter;
use \Hermawan\DataTables\DataTable;

class KategoriAkun extends ResourcePresenter
{
    public function index()
    {
        return view('akun/kategori/index');
    }

    public function getDataKategori()
    {
        if ($this->request->isAJAX()) {

            $modelKategori = new KategoriAkunModel();
            $data = $modelKategori->where(['deleted_at' => null])->select('id, nama, deskripsi, debit_kredit');

            return DataTable::of($data)
                ->addNumbering('no')
                ->add('aksi', function ($row) {
                    return '
                    <a title="Detail" class="px-2 py-0 btn btn-sm btn-outline-dark" onclick="showModalDetail(' . $row->id . ')">
                        <i class="fa-fw fa-solid fa-magnifying-glass"></i>
                    </a>

                    <a title="Edit" class="px-2 py-0 btn btn-sm btn-outline-primary" onclick="showModalEdit(' . $row->id . ')/edit">
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
        if ($this->request->isAJAX()) {
            $modelKategori = new KategoriAkunModel();
            $kategori      = $modelKategori->find($id);

            $data = [
                'kategori' => $kategori
            ];

            $json = [
                'data'   => view('akun/kategori/show', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load data';
        }
    }


    public function new()
    {
        if ($this->request->isAJAX()) {
            $modelKategori = new KategoriAkunModel();
            $kategori      = $modelKategori->findAll();

            $data = [
                'kategori' => $kategori
            ];
 
            $json = [
                'data'   => view('akun/kategori/add', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function create()
    {
        if ($this->request->isAJAX()) {
            $validasi = [
                'nama'       => [
                    'rules'  => 'required|is_unique[divisi.nama]',
                    'errors' => [
                        'required'  => '{field} kategori harus diisi.',
                        'is_unique' => 'nama divisi sudah ada dalam database.'
                    ]
                ],
                'deskripsi'  => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => '{field} harus diisi.'
                    ]
                ],
                'debit'  => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => '{field}/kredit harus diisi.',
                    ]
                ]
            ];

            if (!$this->validate($validasi)) {
                $validation = \Config\Services::validation();

                $error = [
                    'error_nama'       => $validation->getError('nama'),
                    'error_deskripsi'  => $validation->getError('deskripsi'),
                    'error_debit'      => $validation->getError('debit')
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $modelKategori = new KategoriAkunModel();

                $data = [
                    'nama'         => $this->request->getPost('nama'),
                    'deskripsi'    => $this->request->getPost('deskripsi'),
                    'debit_kredit' => $this->request->getPost('debit_kredit')
                ];
                
                $modelKategori->insert($data);

                $json = [
                    'success' => 'Berhasil menambah data kategori'
                ];
            }

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function edit($id = null)
    {
         if ($this->request->isAJAX()) {
            $modelKategori = new KategoriAkunModel();
            $kategori      = $modelKategori->find($id);

            $data = [
                'validation'    => \Config\Services::validation(),
                'kategori'      => $kategori
            ];
 
            $json = [
                'data'   => view('akun/kategori/edit', $data),
            ];

            echo json_encode($json);
        } else {
                return 'Tidak bisa load';
        } 
    }


    public function update($id = null)
    {
        // if ($this->request->isAJAX()) {
            $validasi = [
                'nama'       => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => '{field} nama divisi harus diisi.',
                    ]
                ],
                'deskripsi'  => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => '{field} harus diisi.',
                    ]
                ],
                'debit'  => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => '{field}/kredit harus diisi.',
                    ]
                ]
            ];

            if (!$this->validate($validasi)) {
                $validation = \Config\Services::validation();

                $error = [
                    'error_nama'       => $validation->getError('nama'),
                    'error_deskripsi'  => $validation->getError('deskripsi'),
                    'error_debit'      => $validation->getError('debit')
                ];

                $json = [
                    'error' => $error
                ];

                echo json_encode($json);
            } else {
                $modelKategori = new KategoriAkunModel();
                $kategori      = $modelKategori->find($id);

                $data = [
                    'id'           => $kategori,
                    'nama'         => $this->request->getPost('nama'),
                    'deskripsi'    => $this->request->getPost('deskripsi'),
                    'debit_kredit' => $this->request->getPost('debit_kredit')
                ];
                $modelDivisi->save($data);

                session()->setFlashdata('pesan', 'Data Kategori berhasil diedit.');

                return redirect()->to('/divisi')->withInput();    
            }
        // } else {
        //     return 'Tidak bisa load';
        // }    
    }


    public function delete($id = null)
    {
        $modelKategori = new KategoriAkunModel();

        $modelKategori->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/kategoriakun');
    }

}
