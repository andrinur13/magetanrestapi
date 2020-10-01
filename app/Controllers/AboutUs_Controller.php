<?php

namespace App\Controllers;

use App\Models\AboutUsModel;
use CodeIgniter\RESTful\ResourceController;

class AboutUs_Controller extends ResourceController
{

    protected $modelaboutus;

    public function __construct()
    {
        $this->modelaboutus = new AboutUsModel();
    }

    public function index()
    {
        $cari = $this->modelaboutus->getData();

        if ($cari != null) {
            return $this->respond([
                'status' => 'success',
                'data' => $cari
            ]);
        } else {
            return $this->respond([
                'status' => 'failed',
                'mesages' => 'data not found!'
            ]);
        }
    }



    public function aboutid()
    {
        $id = $this->request->getVar('id');

        if (!$id) {
            // cek apabila dikirim lewat body
            $datainput = $this->request->getRawInput();
            $id = $datainput['id'];
        }

        if (!$id) {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'provide an id!'
            ], 404);
        }

        // id ada
        $cari = $this->modelaboutus->getData($id);

        if ($cari == null) {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'id not found!'
            ], 404);
        } else {
            return $this->respond([
                'status' => 'success',
                'data' => $cari
            ], 200);
        }
    }



    public function createabout()
    {
        helper('form');

        $rules = [
            'name' => 'required',
            'email' => 'required|valid_email',
            'subject' => 'required',
            'messages' => 'required',
        ];

        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            return $this->respond([
                'status' => 'failed',
                'errors' => $validation->getErrors()
            ], 400);
        }

        // tampung data inputan
        $datainputan = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'subject' => $this->request->getPost('subject'),
            'messages' => $this->request->getPost('messages'),
        ];

        $this->modelaboutus->storeData($datainputan);

        return $this->respond([
            'status' => 'success',
            'messages' => 'success added data'
        ], 202);
    }


    public function editaboutus()
    {
        $datainput = $this->request->getRawInput();

        if ($datainput) {
            // ada data input yang masuk
            $id = $datainput['id'];

            $cari = $this->modelaboutus->getData($id);

            if (!$cari) {
                return $this->respond([
                    'status' => 'failed',
                    'messages' => 'id ' . $id . ' not found'
                ], 404);
            } else {
                // data ditemukan
                // bisa diedit
                $dataupdate = [
                    'name' => isset($datainput['name']) ? $datainput['name'] : $cari['name'],
                    'email' => isset($datainput['email']) ? $datainput['email'] : $cari['email'],
                    'subject' => isset($datainput['subject']) ? $datainput['subject'] : $cari['subject'],
                    'messages' => isset($datainput['messages']) ? $datainput['messages'] : $cari['messages'],
                ];

                $this->modelaboutus->updateData($dataupdate, $id);

                return $this->respondUpdated([
                    'status' => 'success',
                    'messages' => 'id ' . $id . ' was updated',
                    'data' => $dataupdate
                ], 204);
            }
        } else {
            return $this->respond([
                'status' => 'failed',
                'id' => 'provide an id'
            ], 404);
        }
    }


    public function deleteabout()
    {
        $datainput = $this->request->getRawInput();

        if (!$datainput) {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'provide an id'
            ], 404);
        } else {
            if (isset($datainput['id'])) {
                $id = $datainput['id'];

                // delete db with id
                $cari = $this->modelaboutus->getData($id);

                if (!$cari) {
                    return $this->respond([
                        'status' => 'failed',
                        'messages' => 'id ' . $id . ' not found'
                    ], 404);
                } else {
                    // data ada
                    $this->modelaboutus->deleteData($id);
                    return $this->respondDeleted([
                        'status' => 'success',
                        'messages' => 'success deleted data with id ' . $id
                    ], 202);
                }
            } else {
                return $this->respond([
                    'status' => 'failed',
                    'messages' => 'provide an id'
                ], 404);
            }
        }
    }
}
