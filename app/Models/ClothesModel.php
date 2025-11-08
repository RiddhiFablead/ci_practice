<?php

namespace App\Models;

use CodeIgniter\Model;

class ClothesModel extends Model
{
    protected $table = 'clothes';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
          'name',      
        'category',
        'condition',
        'image',
        'status',
        'created_at'
    ];

    protected $useTimestamps = false; // We are managing created_at manually

     /**
     * Get all clothes records (for admin)
     */  
    public function getAllClothes()
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }
      //* Get clothes belonging to a specific user
     public function getClothesByUser($userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}
