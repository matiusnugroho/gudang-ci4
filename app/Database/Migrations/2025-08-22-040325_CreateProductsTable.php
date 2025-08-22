<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'category_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true, // boleh null jika tidak berkategori
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'code' => [
                'type' => 'VARCHAR',
                'constraint' => 60,
            ],
            'unit' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
            ],
            'stock' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'unsigned' => true,
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('name');
        $this->forge->addKey('code', false, true); // unique index untuk code
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'SET NULL', 'RESTRICT');
        $this->forge->createTable('products');
    }


    public function down()
    {
        $this->forge->dropTable('products');
    }
}
