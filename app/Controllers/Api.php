<?php

namespace App\Controllers;

use App\Models\PurchaseItemModel;
use App\Models\ProductModel;

class Api extends BaseController
{
    public function purchaseItems($purchaseId)
    {
        $model = new PurchaseItemModel();
        $items = $model->select('purchase_items.*, products.name as product_name')
            ->join('products', 'products.id = purchase_items.product_id')
            ->where('purchase_items.purchase_id', $purchaseId)
            ->findAll();

        return $this->response->setJSON($items);
    }
}
