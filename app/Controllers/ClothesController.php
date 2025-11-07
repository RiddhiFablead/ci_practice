<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClothesModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class ClothesController extends BaseController
{
    public function index()
    {
        $clothesModel =new ClothesModel();
        $userId = session()->get('id');
        $data['clothes']=$clothesModel->where('user_id',$userId)->findAll();
        return view('clothes/index',$data);
    }
    public function add()
    {
        return view('clothes/add');
    }
    public function store()
    {
        $clothesModel =new ClothesModel();
        $userModel =new UserModel();
        $userId =session()->get('id');
        $validation = \Config\Services::validation();

        $validation ->setRules([
            'category' => 'required|max_length[100]',
            'condition' => 'required|max_length[50]',
            'image' => 'uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
        ]);

        if(!$validation->withRequest($this->request)->run()){
            return redirect()->back()
            ->withInput()
            ->with('errors',$validation->getErrors());
        }
        //Handle image upload
        $img=$this->request->getFile('image');
        $newName=$img->getRandomName();
          $img->move(FCPATH . 'uploads/clothes', $newName);


           // ✅ Prepare data
           $data=[
            'user_id'=>$userId,
            'category'=>$this->request->getPost('category'),
              'condition' => $this->request->getPost('condition'),
            'image'     => $newName,
            'status'    => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
           ];


           //save data
           if($clothesModel->insert($data)){
                return redirect()->to('/clothes')->with('success','Clothes Submited  Successfully');
           }
           else{
                return redirect()->back()->with('error','Failed to submit clothes.');
           }
    }

}
