<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth/register');
    }

    public function store()
    {
        $model = new UserModel();
        // ✅ Load validation service
        $validation = \config\Services::validation();
        // ✅ Define validation rules
        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]|max_length[255]',
        ]);
        // ✅ Run validation
        if (!$validation->withRequest($this->request)->run()) {
            // Get all error messages as a single string
            $errors = implode("\n", $validation->getErrors());
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors())
                ->with('error', $errors);
        }

        // ✅ If validation passes, insert data
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ];

        if ($model->insert($data)) {
            return redirect()->to('/login')->with('success', 'Registration Successful');
        } else {
            return redirect()->back()->with('error', 'Failed to register user.');
        }
    }

    public function login()
    {
        return view('auth/login');
    }
    public function checkLogin()
    {
        $session = session();
        $model = new UserModel();
        $validation = \config\Services::validation();

        $validation->setRules([
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]|max_length[255]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            $errors = implode("\n", $validation->getErrors());
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors())
                ->with('error', $errors);
        }
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $user = $model->where('email', $email)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $sessionData = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'isLoggedIn' => true
                ];
                $session->set($sessionData);
                return redirect()->to('/dashboard')->with('success', 'Login Successful!');
            } else {
                return redirect()->back()->with('error', 'Invalid password. Please try again.');
            }
        } else {
            return redirect()->back()->with('error', 'Email not found. Please register first.');
        }
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'You have been logged out.');
    }
}
