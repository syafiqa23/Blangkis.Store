<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transaction extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE,
            ],
            'total_harga' => [
                'type' => 'DOUBLE',
                'null' => FALSE,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => FALSE,
            ],
            'kelurahan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE,
            ],
            'kelurahan_nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE,
            ],
            'layanan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE,
            ],
            'ongkir' => [
                'type' => 'DOUBLE',
                'null' => TRUE
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => 1,
                'null' => FALSE,
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => TRUE
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => TRUE
            ],
            'status_kirim' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'default' => 'diproses',
            ],
            'status_bayar' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'default' => 'belum',
            ],
            'bukti_pembayaran' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE,
            ]
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('transaction');
    }

    public function down()
    {
        $this->forge->dropTable('transaction');
    }
}
