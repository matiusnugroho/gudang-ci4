<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIncomingItemsTable extends Migration
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
'product_id' => [
'type' => 'INT',
'constraint' => 11,
'unsigned' => true,
],
'purchase_item_id' => [
'type' => 'INT',
'constraint' => 11,
'unsigned' => true,
'null' => true, // relasi ke item pembelian (barang masuk harus berasal dari pembelian)
],
'date' => [
'type' => 'DATETIME',
],
'quantity' => [
'type' => 'DECIMAL',
'constraint' => '15,2',
'unsigned' => true,
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
$this->forge->addKey('date');
$this->forge->addForeignKey('product_id', 'products', 'id', 'RESTRICT', 'RESTRICT');
$this->forge->addForeignKey('purchase_item_id', 'purchase_items', 'id', 'RESTRICT', 'SET NULL');
$this->forge->createTable('incoming_items');
}


public function down()
{
$this->forge->dropTable('incoming_items');
}
}
