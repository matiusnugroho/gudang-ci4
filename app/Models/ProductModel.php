<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table         = 'products';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['category_id','name','code','unit','stock'];
    protected $useTimestamps = true;

    // contoh relasi category
    public function getWithCategory()
    {
        return $this->select('products.*, categories.name as category_name')
                    ->join('categories', 'categories.id = products.category_id', 'left')
                    ->findAll();
    }
}
