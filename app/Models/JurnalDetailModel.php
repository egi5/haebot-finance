<?php

namespace App\Models;

use CodeIgniter\Model;

class JurnalDetailModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'transaksi_jurnal_detail';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_transaksi','id_akun','deskripsi','debit','kredit'
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


    public function getDetailJurnal($idDetailJurnal)
    {
        $data =  $this->db->table($this->table)
            ->select('transaksi_jurnal_detail.*, transaksi_jurnal.nomor_transaksi as nomor_transaksi, akun.nama as akun, akun.kode as kode')
            ->join('transaksi_jurnal', 'transaksi_jurnal_detail.id_transaksi = transaksi_jurnal.id', 'left')
            ->join('akun', 'transaksi_jurnal_detail.id_akun = akun.id', 'left')
            ->where('transaksi_jurnal_detail.id', $idDetailJurnal)
            ->get()
            ->getRowArray();

        return $data;
    }
}

?>