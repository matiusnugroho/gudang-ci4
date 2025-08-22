<?php

namespace App\Models;

use CodeIgniter\Model;

class OutgoingItemModel extends Model
{
    protected $table         = 'outgoing_items';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['product_id','date','quantity','note'];
    protected $useTimestamps = true;
}
