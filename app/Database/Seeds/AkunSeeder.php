<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\AkunModel;
use App\Models\KategoriAkunModel;

class AkunSeeder extends Seeder
{
    public function run()
    {
        $akun     = new AkunModel();
        $kategori = new KategoriAkunModel();

        //Kategori Akun
        $kategori->insert([    //1
            'nama'             => 'Kas & Bank',
            'deskripsi'        => '-',
            'debit'            => 1,
            'kredit'           => '-1',
        ]);

        $kategori->insert([    //2
            'nama'             => 'Akun Piutang',
            'deskripsi'        => '-',
            'debit'            => '-1',
            'kredit'           => '1',
        ]);

        $kategori->insert([    //3
            'nama'             => 'Persediaan',
            'deskripsi'        => '-',
            'debit'            => '1',
            'kredit'           => '-1',
        ]);
        
        $kategori->insert([    //4
            'nama'             => 'Aktiva Lancar Lainnya',
            'deskripsi'        => '-',
            'debit'            => '1',
            'kredit'           => '-1',
        ]);

        $kategori->insert([    //5
            'nama'             => 'Aktiva Tetap',
            'deskripsi'        => '-',
            'debit'            => '1',
            'kredit'           => '-1',
        ]);
        
        $kategori->insert([    //6
            'nama'             => 'Hutang',
            'deskripsi'        => '-',
            'debit'            => '-1',
            'kredit'           => '1',
        ]);


        //Akun
        $akun->insert([
            'kode'         => '10001',
            'nama'         => 'Kas',
            'id_kategori'  => '1',
        ]);

        $akun->insert([
            'kode'         => '10002',
            'nama'         => 'Rekening BCA',
            'id_kategori'  => '1',
        ]);

        $akun->insert([
            'kode'         => '10003',
            'nama'         => 'Rekening Mandiri',
            'id_kategori'  => '1',
        ]);

        $akun->insert([
            'kode'         => '10100',
            'nama'         => 'Piutang Usaha',
            'id_kategori'  => '2',
        ]);

        $akun->insert([
            'kode'         => '10200',
            'nama'         => 'Persediaan Barang',
            'id_kategori'  => '3',
        ]);
    }
}
