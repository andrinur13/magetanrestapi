<?php

namespace App\Controllers;

use App\Models\PrestasiModel;
use CodeIgniter\RESTful\ResourceController;

class Prestasi_Controller extends ResourceController
{
    protected $format = 'json';
    protected $modelprestasi;

    public function __construct()
    {
        $this->modelprestasi = new PrestasiModel();
    }


    // query semua data prestasi
    public function index()
    {
        $dataprestasi = $this->modelprestasi->getPrestasi();
        if ($dataprestasi) {
            return $this->respond([
                'status' => 'success',
                'data' => $dataprestasi
            ], 200);
        } else {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'failed get data prestasi'
            ], 404);
        }
    }



    public function prestasiid()
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
                'messages' => 'provide an id'
            ], 400);
        } else {
            $cari = $this->modelprestasi->getPrestasi($id);

            if (!$cari) {
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
    }



    public function prestasiSiswa()
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
                'messages' => 'provide an id'
            ], 400);
        } else {
            $cari = $this->modelprestasi->getPrestasiDataSiswa($id);

            if (!$cari) {
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
    }



    public function create()
    {
        helper('form');

        $rules = [
            'id_data_siswa' => 'required',
            'tingkat' => 'required',
            'penyelenggara' => 'required',
            'nama_kegiatan' => 'required',
            'hasil' => 'required'
        ];


        if (!$this->validate($rules)) {
            // kembalikan pesan error sebagai respon validasi
            $validasi = \Config\Services::validation();
            return $this->respond([
                'status' => 'failed',
                'error' => $validasi->getErrors()
            ], 400);
        }

        $data = [
            'id_data_siswa' => $this->request->getVar('id_data_siswa'),
            'tingkat' => $this->request->getVar('tingkat'),
            'penyelenggara' => $this->request->getVar('penyelenggara'),
            'nama_kegiatan' => $this->request->getVar('nama_kegiatan'),
            'hasil' => $this->request->getVar('hasil'),
            'piagam' => $this->request->getVar('piagam')
        ];

        if ($this->modelprestasi->storePrestasi($data)) {
            return $this->respondCreated([
                'status' => 'success',
                'messages' => 'success added data'
            ], 200);
        } else {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'failed added data'
            ], 400);
        }
    }



    public function editPrestasi()
    {
        $datainput = $this->request->getRawInput();

        if ($datainput) {
            // ada data input yang masuk
            $id = $datainput['id'];

            $cari = $this->modelprestasi->getPrestasi($id);

            if (!$cari) {
                return $this->respond([
                    'status' => 'failed',
                    'messages' => 'id ' . $id . ' not found'
                ], 404);
            } else {
                // data ditemukan
                // bisa diedit
                $dataupdate = [
                    'id_data_siswa' => isset($datainput['id_data_siswa']) ? $datainput['id_data_siswa'] : $cari['id_data_siswa'],
                    'tingkat' => isset($datainput['tingkat']) ? $datainput['tingkat'] : $cari['tingkat'],
                    'penyelenggara' => isset($datainput['penyelenggara']) ? $datainput['penyelenggara'] : $cari['penyelenggara'],
                    'nama_kegiatan' => isset($datainput['nama_kegiatan']) ? $datainput['nama_kegiatan'] : $cari['nama_kegiatan'],
                    'hasil' => isset($datainput['hasil']) ? $datainput['hasil'] : $cari['hasil'],
                    'piagam' => isset($datainput['piagam']) ? $datainput['piagam'] : $cari['piagam']
                ];

                $this->modelprestasi->updatePrestasi($dataupdate, $id);

                return $this->respondUpdated([
                    'status' => 'success',
                    'messages' => 'id ' . $id . ' was updated',
                    'data' => $dataupdate
                ], 202);
            }
        } else {
            return $this->respond([
                'status' => 'failed',
                'id' => 'provide an id'
            ], 400);
        }
    }


    public function deletePrestasi()
    {
        $datainput = $this->request->getRawInput();

        if (!$datainput) {
            return $this->respond([
                'status' => 'failed',
                'provide an id'
            ], 400);
        } else {
            if (isset($datainput['id'])) {
                $id = $datainput['id'];

                // delete db with id
                $cari = $this->modelprestasi->getPrestasi($id);

                if (!$cari) {
                    return $this->respond([
                        'status' => 'failed',
                        'messages' => 'id ' . $id . ' not found'
                    ], 404);
                } else {
                    // data ada
                    $this->modelprestasi->deletePrestasi($id);
                    return $this->respondDeleted([
                        'status' => 'success',
                        'messages' => 'success deleted data with id ' . $id
                    ], 202);
                }
            } else {
                return $this->respond([
                    'status' => 'failed',
                    'messages' => 'provide an id'
                ], 400);
            }
        }
    }
}
