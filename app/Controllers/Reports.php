<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Reports extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    /**
     * Laporan Barang Masuk
     */
    public function incoming()
    {
        $start = $this->request->getGet('start_date');
        $end   = $this->request->getGet('end_date');

        $query = $this->db->table('purchase_items')
            ->select('purchase_items.*, purchases.purchase_date, products.name as product_name, products.code as product_code')
            ->join('purchases', 'purchases.id = purchase_items.purchase_id')
            ->join('products', 'products.id = purchase_items.product_id');

        if ($start && $end) {
            $query->where("DATE(purchases.purchase_date) >=", $start)
                  ->where("DATE(purchases.purchase_date) <=", $end);
        }

        $data = [
            'title'    => 'Laporan Barang Masuk',
            'incoming' => $query->orderBy('purchases.purchase_date', 'DESC')->get()->getResultArray(),
            'start'    => $start,
            'end'      => $end,
        ];

        return view('reports/incoming', $data);
    }

    /**
     * Laporan Barang Keluar
     */
    public function outgoing()
    {
        $start = $this->request->getGet('start_date');
        $end   = $this->request->getGet('end_date');

        $query = $this->db->table('outgoing_items')
            ->select('outgoing_items.*, products.name as product_name, products.code as product_code')
            ->join('products', 'products.id = outgoing_items.product_id');

        if ($start && $end) {
            $query->where("DATE(outgoing_items.date) >=", $start)
                  ->where("DATE(outgoing_items.date) <=", $end);
        }

        $data = [
            'title'    => 'Laporan Barang Keluar',
            'outgoing' => $query->orderBy('outgoing_items.date', 'DESC')->get()->getResultArray(),
            'start'    => $start,
            'end'      => $end,
        ];

        return view('reports/outgoing', $data);
    }

    /**
     * Laporan Stok Barang
     */
    public function stock()
    {
        $query = $this->db->table('products')
            ->select('products.id, products.code, products.name, products.stock')
            ->orderBy('products.name', 'ASC');

        $data = [
            'title'    => 'Laporan Stok Barang',
            'stock' => $query->get()->getResultArray(),
        ];

        return view('reports/stock', $data);
    }
}
