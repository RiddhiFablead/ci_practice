<?php

namespace App\Controllers;

use App\Models\ClothesModel;
use CodeIgniter\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        $session = session();

        // check login
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $userId = $session->get('id');

        $clothesModel = new ClothesModel();

        // stats
        $data['totalClothes']   = $clothesModel->where('user_id', $userId)->countAllResults();
        $data['pendingClothes'] = $clothesModel->where('user_id', $userId)->where('status', 'pending')->countAllResults();
        $data['approvedClothes']= $clothesModel->where('user_id', $userId)->where('status', 'approved')->countAllResults();

        $data['user'] = [
            'name'  => $session->get('name'),
            'email' => $session->get('email'),
        ];

        return view('dashboard', $data);
    }
}
