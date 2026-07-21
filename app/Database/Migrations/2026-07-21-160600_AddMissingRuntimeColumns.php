<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMissingRuntimeColumns extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('name', 'user')) {
            $this->forge->addColumn('user', [
                'name' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                    'after' => 'id',
                ],
            ]);
        }

        if (!$this->db->fieldExists('avatar', 'user')) {
            $this->forge->addColumn('user', [
                'avatar' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                    'after' => 'role',
                ],
            ]);
        }

        if (!$this->db->fieldExists('layanan', 'transaction')) {
            $this->forge->addColumn('transaction', [
                'layanan' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
                    'after' => 'kelurahan_nama',
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('layanan', 'transaction')) {
            $this->forge->dropColumn('transaction', 'layanan');
        }

        if ($this->db->fieldExists('avatar', 'user')) {
            $this->forge->dropColumn('user', 'avatar');
        }

        if ($this->db->fieldExists('name', 'user')) {
            $this->forge->dropColumn('user', 'name');
        }
    }
}
