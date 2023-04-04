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
            'debit'            => '1',
            'kredit'           => '-1',
        ]);

        $kategori->insert([    //2
            'nama'             => 'Piutang',
            'deskripsi'        => '-',
            'debit'            => '1',
            'kredit'           => '-1',
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
            'nama'             => 'Depresiasi dan Amortisasi',
            'deskripsi'        => '-',
            'debit'            => '1',
            'kredit'           => '-1',
        ]);

        $kategori->insert([    //7
            'nama'             => 'Aktiva Lainnya',
            'deskripsi'        => '-',
            'debit'            => '1',
            'kredit'           => '-1',
        ]);
        
        $kategori->insert([    //8
            'nama'             => 'Akun Hutang',
            'deskripsi'        => '-',
            'debit'            => '-1',
            'kredit'           => '1',
        ]);

        $kategori->insert([    //9
            'nama'             => 'Kewajiban Lancar Lainnya',
            'deskripsi'        => '-',
            'debit'            => '-1',
            'kredit'           => '1',
        ]);

        $kategori->insert([    //10
            'nama'             => 'Kewajiban Jangka Panjang',
            'deskripsi'        => '-',
            'debit'            => '-1',
            'kredit'           => '1',
        ]);

        $kategori->insert([    //11
            'nama'             => 'Ekuitas',
            'deskripsi'        => '-',
            'debit'            => '-1',
            'kredit'           => '1',
        ]);

        $kategori->insert([    //12
            'nama'             => 'Pendapatan',
            'deskripsi'        => '-',
            'debit'            => '-1',
            'kredit'           => '1',
        ]);

        $kategori->insert([    //13
            'nama'             => 'Harga Pokok Penjualan',
            'deskripsi'        => '-',
            'debit'            => '1',
            'kredit'           => '-1',
        ]);
        
        $kategori->insert([    //14
            'nama'             => 'Beban',
            'deskripsi'        => '-',
            'debit'            => '1',
            'kredit'           => '-1',
        ]);
        
        $kategori->insert([    //15
            'nama'             => 'Pendapatan Lainnya',
            'deskripsi'        => '-',
            'debit'            => '-1',
            'kredit'           => '1',
        ]);
        
        $kategori->insert([    //16
            'nama'             => 'Beban Lainnya',
            'deskripsi'        => '-',
            'debit'            => '1',
            'kredit'           => '-1',
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
