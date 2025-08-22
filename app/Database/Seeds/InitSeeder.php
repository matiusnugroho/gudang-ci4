<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitSeeder extends Seeder
{
    public function run()
    {
        // --- Categories ---
        $categories = [
            ['name' => 'IT EQUIPMENTS'],
            ['name' => 'OFFICE EQUIPMENTS'],
            ['name' => 'FURNITURES'],
        ];
        $this->db->table('categories')->insertBatch($categories);

        // --- Vendors ---
        $vendors = [
            [
                'name'    => 'PT. Maju Jaya',
                'address' => 'Jl. Merdeka No. 1 Jakarta',
                'phone'   => '021-1234567',
            ],
            [
                'name'    => 'CV. Sukses Selalu',
                'address' => 'Jl. Sudirman No. 25 Bandung',
                'phone'   => '022-7654321',
            ],
        ];
        $this->db->table('vendors')->insertBatch($vendors);

        // --- Products ---
        $products = [
            [
                'category_id' => 1,
                'name'        => 'Laptop Lenovo ThinkPad',
                'code'        => 'IT001',
                'unit'        => 'PCS',
                'stock'       => 10,
            ],
            [
                'category_id' => 1,
                'name'        => 'Printer Canon LBP2900',
                'code'        => 'IT002',
                'unit'        => 'PCS',
                'stock'       => 5,
            ],
            [
                'category_id' => 2,
                'name'        => 'Kertas A4 80gsm',
                'code'        => 'OFF001',
                'unit'        => 'RIM',
                'stock'       => 50,
            ],
            [
                'category_id' => 3,
                'name'        => 'Meja Kantor Kayu',
                'code'        => 'FUR001',
                'unit'        => 'PCS',
                'stock'       => 3,
            ],
        ];
        $this->db->table('products')->insertBatch($products);

        // --- Purchases ---
        $purchases = [
            [
                'vendor_id'     => 1,
                'purchase_date' => date('Y-m-d'),
                'buyer_name'    => 'Admin Gudang',
                'status'        => 'OPEN',
                'notes'         => 'Pembelian awal stok',
            ],
        ];
        $this->db->table('purchases')->insertBatch($purchases);

        // --- Purchase Items ---
        $purchaseItems = [
            [
                'purchase_id' => 1,
                'product_id'  => 1,
                'quantity'    => 5,
                'unit_price'  => 10000000,
            ],
            [
                'purchase_id' => 1,
                'product_id'  => 3,
                'quantity'    => 20,
                'unit_price'  => 60000,
            ],
        ];
        $this->db->table('purchase_items')->insertBatch($purchaseItems);

        // --- Incoming Items ---
        $incoming = [
            [
                'product_id'       => 1,
                'purchase_item_id' => 1,
                'date'             => date('Y-m-d H:i:s'),
                'quantity'         => 5,
            ],
            [
                'product_id'       => 3,
                'purchase_item_id' => 2,
                'date'             => date('Y-m-d H:i:s'),
                'quantity'         => 20,
            ],
        ];
        $this->db->table('incoming_items')->insertBatch($incoming);

        // --- Outgoing Items ---
        $outgoing = [
            [
                'product_id' => 3,
                'date'       => date('Y-m-d H:i:s'),
                'quantity'   => 2,
                'note'       => 'Dipakai untuk keperluan kantor',
            ],
        ];
        $this->db->table('outgoing_items')->insertBatch($outgoing);
        $data = [
            'username'  => 'admin',
            'email'     => 'admin@example.com',
            'full_name' => 'Administrator',
            'password'  => password_hash('12345', PASSWORD_DEFAULT),
            'role'      => 'ADMIN',
            'status'    => 1,
        ];

        // insert ke tabel users
        $this->db->table('users')->insert($data);
    }
}
