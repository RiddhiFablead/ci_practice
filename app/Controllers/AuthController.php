<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{


    /** Show registration page */
    public function index()
    {
        return view('register');
    }

    /** Handle registration POST */
    public function store()
    {
       $model = new UserModel();

         $data = [
              'username' => $this->request->getPost('username'),
              'email'    => $this->request->getPost('email'),
              'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
         ];

         $model->insert($data);

        return redirect()->to(site_url('/'))->with('success', 'Registration successful! You can now log in.');

    }
}
