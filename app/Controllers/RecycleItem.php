<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RecycleItemModel;
use CodeIgniter\HTTP\ResponseInterface;

class RecycleItem extends BaseController
{
    public function index()
    {
        $model = new  RecycleItemModel();
        $data['items']=$model->orderBy('id','DESC')->findAll();
        return view('admin/recycle/list',$data);
    }
    public function create()
    {
        return view('admin/recycle/create');
    }
    public function store()
    {
        $validation=\config\Services::validation();
        $validation->setRules([
            'user_name'    => 'required|min_length[2]|max_length[100]',
             'item_name'    => 'required|min_length[2]|max_length[100]',
            'category'     => 'required|max_length[50]',
            'weight'       => 'required|decimal',
            'status'       => 'required|in_list[pending,approved,rejected]',
            'reward_coins' => 'required|integer',
        ]);
        if(!$validation->withRequest($this->request)->run())
        {
            return $this->response->setJSON([
                'status'=>'error',
                'errors'=>$validation->getErrors()
            ]);
        }
        $model= new RecycleItemModel();
        $model->save([
              'user_name'    => $this->request->getPost('user_name'),
            'item_name'    => $this->request->getPost('item_name'),
            'category'     => $this->request->getPost('category'),
            'weight'       => $this->request->getPost('weight'),
            'status'       => $this->request->getPost('status'),
            'reward_coins' => $this->request->getPost('reward_coins'),
        ]);
         return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Recycle item added successfully ✅'
        ]);
    }
    public function edit($id)
    {
        $model = new RecycleItemModel();
        $item = $model->find($id);

        if (!$item) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Recycle item not found.'
            ]);
        }

        return $this->response->setJSON($item);
    }

    public function update()
    {
        $model = new RecycleItemModel();
        $id = $this->request->getPost('id');
        $item = $model->find($id);

        if (!$item) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Item not found.'
            ]);
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'user_id'      => 'required|integer',
            'item_name'    => 'required|min_length[2]|max_length[100]',
            'category'     => 'required|max_length[50]',
            'weight'       => 'required|decimal',
            'status'       => 'required|in_list[pending,approved,rejected]',
            'reward_coins' => 'required|integer',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors()
            ]);
        }

        $model->update($id, [
            'user_id'      => $this->request->getPost('user_id'),
            'item_name'    => $this->request->getPost('item_name'),
            'category'     => $this->request->getPost('category'),
            'weight'       => $this->request->getPost('weight'),
            'status'       => $this->request->getPost('status'),
            'reward_coins' => $this->request->getPost('reward_coins'),
        ]);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Recycle item updated successfully ✅'
        ]);
    }

    public function delete($id)
    {
        $model = new RecycleItemModel();
        $item = $model->find($id);

        if (!$item) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Item not found.'
            ]);
        }

        $model->delete($id);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Recycle item deleted successfully 🗑️'
        ]);
    }
}
