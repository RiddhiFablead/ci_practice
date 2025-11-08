<?php

namespace App\Models;

use CodeIgniter\Model;

class ChatModel extends Model
{
    protected $table            = 'chat_history';
    protected $primaryKey       = 'id';
    
   
    protected $allowedFields =['user_id', 'message', 'response', 'created_at'];
     protected $useTimestamps = false;
  
   
    

 


   
 

    

    

   
}
