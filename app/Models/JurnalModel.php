<?php

namespace App\Models;

use CodeIgniter\Model;

class JurnalModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'transaksi_jurnal';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nomor_transaksi','referensi','tanggal','total_transaksi','created_at', 'updated_at', 'deleted_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function getJurnal($idJurnal)
    {
        $data =  $this->db->table($this->table)
            ->where('transaksi_jurnal.deleted_at', null)
            ->where('nomer_transaksi',$idJurnal)
            ->get()
            ->getRowArray();

        return $data;
    }


    public function getAkunBuku($idAkun, $tglAwal, $tglAkhir)
    {
        $data = $this->db->table($this->table)
            ->select('transaksi_jurnal.tanggal as tanggal , transaksi_jurnal.nomor_transaksi as nomor,transaksi_jurnal.referensi as referensi, transaksi_jurnal_detail.debit as debit, transaksi_jurnal_detail.kredit as kredit, akun_kategori.debit as ktdebit, akun_kategori.kredit as ktkredit')
            ->join('transaksi_jurnal_detail', 'transaksi_jurnal.id = transaksi_jurnal_detail.id_transaksi', 'left')
            ->join('akun', 'transaksi_jurnal_detail.id_akun = akun.id', 'left')
            ->join('akun_kategori','akun.id_kategori = akun_kategori.id')
            ->where('transaksi_jurnal.deleted_at', null)
            ->where('transaksi_jurnal_detail.id_akun', $idAkun)
            ->where('transaksi_jurnal.tanggal>=', $tglAwal)
            ->where('transaksi_jurnal.tanggal <=', $tglAkhir)
            ->get()->getResultArray();
        
        return $data;
    }


    public function getNeraca($kategori)
    {
        $data = $this->db->table($this->table)
            ->select('transaksi_jurnal.tanggal as tanggal , transaksi_jurnal.nomor_transaksi as nomor, transaksi_jurnal_detail.debit as debit, transaksi_jurnal_detail.kredit as kredit, akun_kategori.debit as ktdebit, akun_kategori.kredit as ktkredit, akun_kategori.nama as ktnama, akun.nama, akun.kode')
            ->join('transaksi_jurnal_detail', 'transaksi_jurnal.id = transaksi_jurnal_detail.id_transaksi', 'left')
            ->join('akun', 'transaksi_jurnal_detail.id_akun = akun.id', 'left')
            ->join('akun_kategori','akun.id_kategori = akun_kategori.id')
            ->where('transaksi_jurnal.deleted_at', null)
            ->where('akun_kategori.nama', $kategori)
            ->get()->getResultArray();
        
        return $data;
    }

}

?>