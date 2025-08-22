<?php

namespace App\Models;

use CodeIgniter\Model;

class IncomingItemModel extends Model
{
    protected $table         = 'incoming_items';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['product_id','purchase_item_id','date','quantity'];
    protected $useTimestamps = true;
}
