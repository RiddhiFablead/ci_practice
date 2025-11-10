<?php

namespace App\Models;

use CodeIgniter\Model;

class RecycleItemModel extends Model
{
    protected $table            = 'recycleitems';
    protected $primaryKey       = 'id';
  protected $allowedFields = [
        'user_id',
        'item_name',
        'category',
        'weight',
        'status',
        'reward_coins',
        'created_at',
        'updated_at',
    ];
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

   
   
  

   

  
  
}
