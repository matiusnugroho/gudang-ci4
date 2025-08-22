<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePurchasesTable extends Migration
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
'vendor_id' => [
'type' => 'INT',
'constraint' => 11,
'unsigned' => true,
],
'purchase_date' => [
'type' => 'DATE',
],
'buyer_name' => [
'type' => 'VARCHAR',
'constraint' => 100,
'null' => true,
],
'status' => [
'type' => 'ENUM',
'constraint' => ['OPEN', 'CLOSED'],
'default' => 'OPEN',
],
'notes' => [
'type' => 'TEXT',
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
$this->forge->addKey('purchase_date');
$this->forge->addForeignKey('vendor_id', 'vendors', 'id', 'RESTRICT', 'RESTRICT');
$this->forge->createTable('purchases');
}


public function down()
{
$this->forge->dropTable('purchases');
}
}
