<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClothesModel;
use App\Models\UserModel;

class ClothesController extends BaseController
{
    // public function index()
    // {
    //     $clothesModel = new ClothesModel();
    //     $userId = session()->get('id');

    //     $data['clothes'] = $clothesModel->where('user_id', $userId)->findAll();

    //     return view('clothes/index', $data);
    // }

    public function index()
    {
        $clothesModel = new ClothesModel();
        $builder=$clothesModel->builder();
        $builder->select('clothes.*,users.name as user_name');
        $builder->join('users','users.id=clothes.user_id');
        $builder->orderBy('clothes.created_at','DESC');
        $data['clothes']=$builder->get()->getResultArray();
        return view('clothes/index',$data);
    }
    public function add()
    {
        return view('clothes/add');
    }

   public function store()
{
    $validation = \Config\Services::validation();

    $validation->setRules([
          
          'name'      => 'required|min_length[2]', 
        'category'  => 'required',
        'condition' => 'required',
         'status'    => 'required|in_list[pending,approved,rejected]',  
        'image'     => 'uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        return $this->response->setJSON([
            'status' => 'error',
            'errors' => $validation->getErrors()
        ]);
    }

    $imageFile = $this->request->getFile('image');
    $imageName = $imageFile->getRandomName();
    $imageFile->move(FCPATH . 'uploads/clothes', $imageName);

    $model = new \App\Models\ClothesModel();
    $model->save([
        'user_id'   => session()->get('id'),
          'name'      => $this->request->getPost('name'),  // Added giver’s name
        'category'  => $this->request->getPost('category'),
        'condition' => $this->request->getPost('condition'),
          'status'    => $this->request->getPost('status'),
        'image'     => $imageName,
    ]);

    return $this->response->setJSON([
        'status'  => 'success',
        'message' => 'Your clothes have been added successfully! 🌿'
    ]);
}
    public function edit($id)
    {
        $model=new ClothesModel();
        $item=$model->find($id);

        if(!$item)
        {
            return $this->response->setJSON(['status'=>'error','message'=>'Item not found']);
        }
        return $this->response->setJSON($item);
    }
     // ✅ Update (AJAX)
    public function update()
    {
        $model = new ClothesModel();
        $id = $this->request->getPost('id');
        $item = $model->find($id);

        if (!$item) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Item not found']);
        }

        $data = [
            'category'  => $this->request->getPost('category'),
            'condition' => $this->request->getPost('condition'),
        ];

        // ✅ If new image uploaded
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/clothes', $newName);

            // remove old image
            if (is_file(FCPATH . 'uploads/clothes/' . $item['image'])) {
                unlink(FCPATH . 'uploads/clothes/' . $item['image']);
            }

            $data['image'] = $newName;
        }

        $model->update($id, $data);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Clothes updated successfully ✅'
        ]);
    }

    public function delete($id)
    {
        $model = new ClothesModel();
        $item=$model->find($id);
        if(!$item)
        {
            return $this->response->setJSON(['status'=>'error','message'=>'Item not found']);
        }
       // Delete image file
        if (is_file(FCPATH . 'uploads/clothes/' . $item['image'])) {
            unlink(FCPATH . 'uploads/clothes/' . $item['image']);
        }
        $model->delete($id);
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Item deleted successfully 🗑️'
        ]);

    }
    public function download($id)
    {
        $model=new ClothesModel();
        $item =$model->find($id);
        if(!$item)
        {
            return redirect()->back()->with('error','Item not found');
        }
          $filePath = FCPATH . 'uploads/clothes/' . $item['image'];
        if (file_exists($filePath)) {
            return $this->response->download($filePath, null);
        } else {
            return redirect()->back()->with('error', 'File not found');
        }
    }
}
