<?php

namespace App\Controllers;

use App\Models\IjazahModel;
use CodeIgniter\RESTful\ResourceController;

class Ijazah_Controller extends ResourceController
{
    protected $modelijazah;

    public function __construct()
    {
        $this->modelijazah = new IjazahModel();
    }


    public function index()
    {
        $cari = $this->modelijazah->getIjazah();

        if ($cari == null) {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'failed get data ijazah'
            ], 400);
        } else {
            return $this->respond([
                'status' => 'success',
                'data' => $cari
            ], 200);
        }
    }



    public function ijazahid()
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
            ], 400);
        } else {
            $hasil = $this->modelijazah->getIjazah($id);

            if (!$hasil) {
                return $this->respond([
                    'status' => 'failed',
                    'messages' => $id . ' not found'
                ], 404);
            } else {
                return $this->respond([
                    'status' => 'success',
                    'data' => $hasil
                ], 200);
            }
        }
    }


    public function createIjazah()
    {
        helper('form');

        $rules = [
            'id_data_siswa' => 'required',
            'link_ijazah' => 'required'
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
            'id_data_siswa' => $this->request->getVar('id_data_siswa'),
            'link_ijazah' => $this->request->getVar('link_ijazah'),
        ];

        if ($this->modelijazah->storeIjazah($datainputan)) {
            return $this->respondCreated([
                'status' => 'success',
                'messages' => 'success add data'
            ], 202);
        } else {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'failed to added data'
            ], 202);
        }
    }


    public function editIjazah()
    {
        $datainput = $this->request->getRawInput();
        if (isset($datainput['id'])) {
            $id = $datainput['id'];

            $cari = $this->modelijazah->getIjazah($id);

            if ($cari == null) {
                return $this->respond([
                    'status' => 'failed',
                    'messages' => 'id ' . $id . ' not found!'
                ], 404);
            } else {
                // jika data ditemukan

                $datahasiledit = [
                    'id_data_siswa' => isset($datainput['id_data_siswa']) ? $datainput['id_data_siswa'] : $cari['id_data_siswa'],
                    'link_ijazah' => isset($datainput['link_ijazah']) ? $datainput['link_ijazah'] : $cari['link_ijazah'],
                ];

                if ($this->modelijazah->editIjazah($datahasiledit, $id)) {
                    return $this->respondUpdated([
                        'status' => 'success',
                        'messages' => 'success update data'
                    ], 202);
                } else {
                    return $this->respond([
                        'status' => 'failed',
                        'messages' => 'failed to update data'
                    ], 202);
                }
            }
        } else {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'provide an id!'
            ], 400);
        }
    }


    public function deleteIjazah()
    {
        $datainput = $this->request->getRawInput();
        if(isset($datainput['id'])) {
            $id = $datainput['id'];

            $cari = $this->modelijazah->getIjazah($id);

            if($cari == null) {
                return $this->respond([
                    'status' => 'failed',
                    'messages' => 'id ' . $id . ' not found!'
                ], 404);
            } else {
                // delete data with id
                $this->modelijazah->deleteIjazah($id);
                return $this->respondDeleted([
                    'status' => 'success',
                    'messages' => 'success delete data with id ' . $id
                ], 202);
            }

        } else {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'provide an id'
            ], 400);
        }
    }


    public function cobagetserver()
    {
        $authHeader = $this->request->getServer('HTTP_AUTHORIZATION');
        $authHeader = explode(' ', $authHeader);
        $authHeader = $authHeader[1];

        return $this->respond([
            'auth' => $authHeader
        ]);
    }
    
}
