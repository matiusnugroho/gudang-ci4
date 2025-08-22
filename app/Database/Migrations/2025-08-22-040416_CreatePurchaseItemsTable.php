<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePurchaseItemsTable extends Migration
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
'purchase_id' => [
'type' => 'INT',
'constraint' => 11,
'unsigned' => true,
],
'product_id' => [
'type' => 'INT',
'constraint' => 11,
'unsigned' => true,
],
'quantity' => [
'type' => 'DECIMAL',
'constraint' => '15,2',
'unsigned' => true,
],
'unit_price' => [
'type' => 'DECIMAL',
'constraint' => '15,2',
'unsigned' => true,
'default' => 0,
'null' => true,
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
$this->forge->addKey(['purchase_id', 'product_id']);
$this->forge->addForeignKey('purchase_id', 'purchases', 'id', 'CASCADE', 'CASCADE');
$this->forge->addForeignKey('product_id', 'products', 'id', 'RESTRICT', 'RESTRICT');
$this->forge->createTable('purchase_items');
}


public function down()
{
$this->forge->dropTable('purchase_items');
}
}
