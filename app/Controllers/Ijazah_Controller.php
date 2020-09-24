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
            ]);
        } else {
            return $this->respond([
                'status' => 'success',
                'data' => $cari
            ]);
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
            ]);
        } else {
            $hasil = $this->modelijazah->getIjazah($id);

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
            ]);
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
            ]);
        } else {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'failed to added data'
            ]);
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
                ]);
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
                ]);
            } else {
                // delete data with id
                $this->modelijazah->deleteIjazah($id);
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
