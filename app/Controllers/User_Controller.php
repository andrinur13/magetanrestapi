<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class User_Controller extends ResourceController
{
    protected $modeluser;

    public function __construct()
    {
        $this->modeluser = new UserModel();
    }


    public function index()
    {
        $cari = $this->modeluser->getUser();

        if ($cari == null) {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'failed get data user'
            ]);
        } else {
            return $this->respond([
                'status' => 'success',
                'data' => $cari
            ]);
        }
    }



    public function userid()
    {
        // request dengan params;
        $id = $this->request->getVar('id');

        if ($id == null) {
            $inputan = $this->request->getRawInput();
            if (isset($inputan['id'])) {
                $id = $inputan['id'];
            }
        }

        if (!$id) {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'provide an id'
            ]);
        } else {
            $hasil = $this->modeluser->getUser($id);

            if (!$hasil) {
                return $this->respond([
                    'status' => 'failed',
                    'messages' => $id . ' not found'
                ]);
            } else {
                return $this->respond([
                    'status' => 'success',
                    'data' => $hasil
                ]);
            }
        }
    }


    public function createUser()
    {
        helper('form');

        $rules = [
            'id_user_type' => 'required|in_list[1, 2, 3]',
            'username' => 'required|is_unique[user.username]',
            'name' => 'required',
            'email' => 'required|valid_email',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            return $this->respond([
                'status' => 'failed',
                'errors' => $validation->getErrors()
            ]);
        }

        // tampung data inputan
        $datainputan = [
            'id_user_type' => $this->request->getPost('id_user_type'),
            'username' => $this->request->getPost('username'),
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ];

        if ($this->modeluser->storeUser($datainputan)) {
            return $this->respondCreated([
                'status' => 'success',
                'messages' => 'success add data'
            ]);
        } else {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'failed to added data'
            ]);
        }
    }


    public function editUser()
    {
        $datainput = $this->request->getRawInput();
        if (isset($datainput['id'])) {
            $id = $datainput['id'];

            $cari = $this->modeluser->getUser($id);

            if ($cari == null) {
                return $this->respond([
                    'status' => 'failed',
                    'messages' => 'id ' . $id . ' not found!'
                ]);
            } else {
                // jika data ditemukan

                $datahasiledit = [
                    'id_user_type' => isset($datainput['id_user_type']) ? $datainput['id_user_type'] : $cari['id_user_type'],
                    'username' => isset($datainput['username']) ? $datainput['username'] : $cari['username'],
                    'name' => isset($datainput['name']) ? $datainput['name'] : $cari['name'],
                    'email' => isset($datainput['email']) ? $datainput['email'] : $cari['email'],
                    'password' => isset($datainput['password']) ? $datainput['password'] : $cari['password'],

                ];

                if ($this->modeluser->editUser($datahasiledit, $id)) {
                    return $this->respondUpdated([
                        'status' => 'success',
                        'messages' => 'success update data'
                    ]);
                } else {
                    return $this->respond([
                        'status' => 'failed',
                        'messages' => 'failed to update data'
                    ]);
                }
            }
        } else {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'provide an id!'
            ]);
        }
    }


    public function deleteUser()
    {
        $datainput = $this->request->getRawInput();
        if(isset($datainput['id'])) {
            $id = $datainput['id'];

            $cari = $this->modeluser->getUser($id);

            if($cari == null) {
                return $this->respond([
                    'status' => 'failed',
                    'messages' => 'id ' . $id . ' not found!'
                ]);
            } else {
                // delete data with id
                $this->modeluser->deleteUser($id);
                return $this->respondDeleted([
                    'status' => 'success',
                    'messages' => 'success delete data with id ' . $id
                ]);
            }

        } else {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'provide an id'
            ]);
        }
    }
    
}
