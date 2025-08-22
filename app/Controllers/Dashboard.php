<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductModel;
use App\Models\IncomingItemModel;
use App\Models\OutgoingItemModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $productModel  = new ProductModel();
        $incomingModel = new IncomingItemModel();
        $outgoingModel = new OutgoingItemModel();

        $totalProducts = $productModel->countAllResults();
        $totalIncoming = $incomingModel->selectSum('quantity')->get()->getRow()->quantity ?? 0;
        $totalOutgoing = $outgoingModel->selectSum('quantity')->get()->getRow()->quantity ?? 0;

        return view('dashboard/index', [
            'totalProducts' => $totalProducts,
            'totalIncoming' => $totalIncoming,
            'totalOutgoing' => $totalOutgoing,
        ]);
    }
}
