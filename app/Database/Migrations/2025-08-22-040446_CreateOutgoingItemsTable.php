<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOutgoingItemsTable extends Migration
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
'date' => [
'type' => 'DATETIME',
],
'quantity' => [
'type' => 'DECIMAL',
'constraint' => '15,2',
'unsigned' => true,
],
'note' => [
'type' => 'VARCHAR',
'constraint' => 150,
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
$this->forge->addKey('date');
$this->forge->addForeignKey('product_id', 'products', 'id', 'RESTRICT', 'RESTRICT');
$this->forge->createTable('outgoing_items');
}


    public function down()
    {
    $this->forge->dropTable('outgoing_items');
    }
}
