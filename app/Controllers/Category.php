<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use CodeIgniter\HTTP\ResponseInterface;

class Category extends BaseController
{
    public function index()
    {
        $model = new CategoryModel();
        $data['categories']=$model->orderBy('id','DESC')->findAll();
        return view('admin/category/list',$data);
    }
    public function create()
    {
        return view('admin/category/create');

    }
    public function store()
    {
        $validation =  \Config\Services::validation();
        $validation->setRules([
             'name' => 'required|min_length[2]|max_length[100]|is_unique[categories.name]',
            'description' => 'permit_empty|max_length[255]',
            'status' => 'required|in_list[active,inactive]',
        ]);
        if(!$validation->withRequest($this->request)->run())
        {
            return $this->response->setJSON([
                'status'=>'error',
                'errors'=>$validation->getErrors()
            ]);
        }
        $model = new CategoryModel();
        $model->save([
            'name'=>$this->request->getPost('name'),
            'description'=>$this->request->getPost('description'),
            'status'=>$this->request->getPost('status'),


        ]);
        return $this->response->setJSON([
            'status'=>'success',
            'message'=>'Category created successfully'
        ]);
    }
     public function edit($id)
    {
        $model = new CategoryModel();
        $category = $model->find($id);

        if (!$category) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Category not found.'
            ]);
        }

        // ✅ Return JSON (used for AJAX modal)
        return $this->response->setJSON($category);
    }

    public function update()
    {
        $model = new CategoryModel();
        $id = $this->request->getPost('id');
        $category = $model->find($id);

        if (!$category) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Category not found.'
            ]);
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name'        => "required|min_length[2]|max_length[100]|is_unique[categories.name,id,{$id}]",
            'description' => 'permit_empty|max_length[255]',
            'status'      => 'required|in_list[active,inactive]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors()
            ]);
        }

        $model->update($id, [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'status'      => $this->request->getPost('status'),
        ]);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Category updated successfully ✅'
        ]);
    }
    public function delete($id)
    {
        $model=new CategoryModel();
        $category=$model->find($id);
        if(!$category){
            return $this->response->setJSON([
                  'status' => 'error',
                'message' => 'Category not found.'
            ]);
        }
        $model->delete($id);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Category deleted successfully 🗑️'
        ]);
    }
    public function getActiveCategories()
{
    $model = new CategoryModel();
    $categories = $model->where('status', 'active')->orderBy('name', 'ASC')->findAll();

    return $this->response->setJSON([
        'status' => 'success',
        'categories' => $categories
    ]);
}

  
        
    }

