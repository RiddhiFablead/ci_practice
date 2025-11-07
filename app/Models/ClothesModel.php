<?php

namespace App\Models;

use CodeIgniter\Model;

class ClothesModel extends Model
{
    protected $table = 'clothes';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'category',
        'condition',
        'image',
        'status',
        'created_at'
    ];

    protected $useTimestamps = false; // We are managing created_at manually
}
