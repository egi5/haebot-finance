<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Finance extends Migration
{
    public function up()
    {
        //Kategori Akun
        $fields = [
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama'             => ['type' => 'varchar', 'constraint' => 80],
            'deskripsi'        => ['type' => 'varchar', 'constraint' => 255],
            'debit_kredit'     => ['type' => 'ENUM', 'constraint' => ['Plus', 'Minus'], 'default' => 'Plus'],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable('akun_kategori', true);


        //Akun
        $fields = [
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kode'             => ['type' => 'varchar', 'constraint' => 10],
            'nama'             => ['type' => 'varchar', 'constraint' => 80],
            'id_kategori'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_kategori', 'akun_kategori', 'id', '', 'CASCADE');
        $this->forge->createTable('akun', true);
    }

    public function down()
    {
        $this->forge->dropTable('akun_kategori');
        $this->forge->dropTable('akun');
    }
}
