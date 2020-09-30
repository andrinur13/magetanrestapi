<?php

namespace App\Controllers;

use App\Models\PelanggaranModel;
use CodeIgniter\RESTful\ResourceController;

class Pelanggaran_Controller extends ResourceController
{

    protected $format = 'json';
    protected $modelpelanggaran;

    public function __construct()
    {
        $this->modelpelanggaran = new PelanggaranModel();
    }


    public function index()
    {
        $cari = $this->modelpelanggaran->getPelanggaran();

        if ($cari) {
            return $this->respond([
                'status' => 'success',
                'data' => $cari
            ]);
        } else {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'failed to get pelanggaran data'
            ]);
        }
    }



    public function pelanggaranid()
    {
        $id = $this->request->getVar('id');

        if ($id == null) {
            $datainput = $this->request->getRawInput();
            $id = $datainput['id'];
        }


        if (!$id) {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'provide an id!'
            ]);
        } else {
            $cari = $this->modelpelanggaran->getPelanggaran($id);

            if ($cari) {
                return $this->respond([
                    'status' => 'success',
                    'data' => $cari
                ]);
            } else {
                return $this->respond([
                    'status' => 'failed',
                    'messages' => 'id ' . $id . ' not found!'
                ]);
            }
        }
    }



    public function createPelanggaran()
    {
        helper('form');

        $rules = [
            'id_data_siswa' => 'required',
            'jenis' => 'required|in_list[1, 2, 3, 4]',
            'nama_pelanggaran' => 'required',
            'hukuman' => 'required',
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
            'jenis' => $this->request->getVar('jenis'),
            'nama_pelanggaran' => $this->request->getVar('nama_pelanggaran'),
            'hukuman' => $this->request->getVar('hukuman')
        ];

        $this->modelpelanggaran->storePelanggaran($datainputan);

        return $this->respondCreated([
            'status' => 'success',
            'messages' => 'success add data'
        ]);
    }



    public function editPelanggaran()
    {
        $datainput = $this->request->getRawInput();
        if (isset($datainput['id'])) {
            $id = $datainput['id'];

            $cari = $this->modelpelanggaran->getPelanggaran($id);

            if ($cari == null) {
                return $this->respond([
                    'status' => 'failed',
                    'messages' => 'id ' . $id . ' not found!'
                ]);
            } else {
                // jika data ditemukan

                $datahasiledit = [
                    'id_data_siswa' => isset($datainput['id_data_siswa']) ? $datainput['id_data_siswa'] : $cari['id_data_siswa'],
                    'jenis' => isset($datainput['jenis']) ? $datainput['jenis'] : $cari['jenis'],
                    'nama_pelanggaran' => isset($datainput['nama_pelanggaran']) ? $datainput['nama_pelanggaran'] : $cari['nama_pelanggaran'],
                    'hukuman' => isset($datainput['hukuman']) ? $datainput['hukuman'] : $cari['hukuman']
                ];

                if ($this->modelpelanggaran->editPelanggaran($datahasiledit, $id)) {
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


    public function deletePelanggaran()
    {
        $datainput = $this->request->getRawInput();
        if(isset($datainput['id'])) {
            $id = $datainput['id'];

            $cari = $this->modelpelanggaran->getPelanggaran($id);

            if($cari == null) {
                return $this->respond([
                    'status' => 'failed',
                    'messages' => 'id ' . $id . ' not found!'
                ]);
            } else {
                // delete data with id
                $this->modelpelanggaran->deletePelanggaran($id);
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
