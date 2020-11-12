<?php

namespace App\Controllers;

use App\Models\DataSiswaModel;
use CodeIgniter\RESTful\ResourceController;

use function PHPSTORM_META\type;

class Data_Siswa_Controller extends ResourceController
{
    protected $format = 'json';
    protected $modeldatasiswa;



    public function __construct()
    {
        $this->modeldatasiswa = new DataSiswaModel();
    }



    public function index()
    {
        $datasiswa = $this->modeldatasiswa->getDataSiswa();

        if ($datasiswa) {
            return $this->respond([
                'status' => 'success',
                'data' => $datasiswa
            ], 200);
        } else {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'data failed to query'
            ], 404);
        }
    }




    public function siswaid()
    {
        // request dengan params;
        $id = $this->request->getVar('id');

        if ($id == null) {
            $inputan = $this->request->getRawInput();
            $id = $inputan['id'];
        }

        if (!$id) {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'provide an id'
            ], 404);
        } else {
            $hasil = $this->modeldatasiswa->getDataSiswa($id);

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


    public function statistiksiswa()
    {
        $siswa = $this->modeldatasiswa->getDataSiswa();

        if(!$siswa) {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'siswa not found!'
            ], 404);
        } else {

            $tahunlulus = [];
            $gender = [];
            for($i=0; $i<count($siswa); $i++) {
                $tahunlulus[] = $siswa[$i]['tahun_lulus'];
                $gender[] = $siswa[$i]['jenis_kelamin'];
            }

            $tahunlulus_count = array_count_values($tahunlulus);
            $gender_count = array_count_values($gender);


            // tahun lulus
            $tahunlulus_final = [];
            foreach($tahunlulus_count as $tc => $val) {
                $temp = [
                    'tahun' => $tc,
                    'value' => $val
                ];

                array_push($tahunlulus_final, $temp);
            }


            // gender
            $gender_final = [];
            foreach ($gender_count as $gc => $val) {
                $temp = [
                    'tahun' => $gc,
                    'value' => $val
                ];

                array_push($gender_final, $temp);
            }

        
            return $this->respond([
                'status' => 'success',
                'data' => [
                    'tahun' => $tahunlulus_final,
                    'gender' => $gender_final
                ]
            ]);
        }
    }

    
    public function create()
    {
        helper('form');

        $rules = [
            'nisn' => 'required|min_length[1]|max_length[100]',
            'nik' => 'required|min_length[1]|max_length[100]',
            'nama' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'tahun_lulus' => 'required',
            'tgl_lahir' => 'valid_date',
            'alamat' => 'required',
            'lulus' => 'required'
        ];

        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            return $this->respond([
                'status' => 'failed',
                'errors' => $validation->getErrors()
            ], 400);
        }

        // status kelulusan
        $lulus = $this->request->getVar('lulus');
        if ((!$lulus) && $lulus != 1) {
            $lulus = 0;
        } else {
            $lulus = 1;
        }


        $dataInputan = [
            'nisn' => $this->request->getVar('nisn'),
            'nik' => $this->request->getVar('nik'),
            'nama' => $this->request->getVar('nama'),
            'kelas' => $this->request->getVar('kelas'),
            'jurusan' => $this->request->getVar('jurusan'),
            'tahun_lulus' => $this->request->getVar('tahun_lulus'),
            'tgl_lahir' => $this->request->getVar('tgl_lahir'),
            'alamat' => $this->request->getVar('alamat'),
            'lulus' => $lulus,
            'skhu' => $this->request->getVar('skhu'),
            'ijazah' => $this->request->getVar('ijazah')
        ];

        // insert ke database;
        if ($this->modeldatasiswa->storeDataSiswa($dataInputan)) {
            return $this->respondCreated([
                'status' => 'success'
            ], 202);
        } else {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'data failed to store'
            ], 400);
        }
    }



    public function editsiswa()
    {
        $data_input = $this->request->getRawInput();

        if ($data_input) {
            // ada data yang masuk dari request
            $id = $data_input['id'];

            $datayangmaudiedit = $this->modeldatasiswa->getDataSiswa($id);

            if (!$datayangmaudiedit) {
                // data tidak ditemukan
                return $this->respond([
                    'status' => 'failed',
                    'messages' => 'id not found'
                ], 404);
            } else {
                // data ditemukan
                $datahasiledit = [
                    'nisn' => isset($data_input['nik']) ? $data_input['nik']: $datayangmaudiedit['nik'],
                    'nik' => isset($data_input['nik']) ? $data_input['nik'] : $datayangmaudiedit['nik'],
                    'nama' => isset($data_input['nama']) ? $data_input['nama'] : $datayangmaudiedit['nama'],
                    'kelas' => isset($data_input['kelas']) ? $data_input['kelas'] : $datayangmaudiedit['kelas'],
                    'jurusan' => isset($data_input['jurusan']) ? $data_input['jurusan'] : $datayangmaudiedit['jurusan'],
                    'tahun_lulus' => isset($data_input['tahun_lulus']) ? $data_input['tahun_lulus'] : $datayangmaudiedit['tahun_lulus'],
                    'tgl_lahir' => isset($data_input['tgl_lahir']) ? $data_input['tgl_lahir'] : $datayangmaudiedit['tgl_lahir'],
                    'alamat' => isset($data_input['alamat']) ? $data_input['alamat'] : $datayangmaudiedit['alamat'],
                    'lulus' => isset($data_input['lulus']) ? $data_input['lulus'] : $datayangmaudiedit['lulus'],
                    'skhu' => isset($data_input['skhu']) ? $data_input['skhu'] : $datayangmaudiedit['skhu'],
                    'ijazah' => isset($data_input['ijazah']) ? $data_input['ijazah'] : $datayangmaudiedit['ijazah']
                ];

                if($this->modeldatasiswa->updateDataSiswa($datahasiledit, $id)) {
                    return $this->respondUpdated([
                        'status' => 'success',
                        'messages' => 'success update data with id' . $id,
                        'data' => $datahasiledit
                    ], 202);
                } else {
                    return $this->respond([
                        'status' => 'failed',
                        'messages' => 'failed update data with id ' . $id
                    ], 400);
                }
            }
        } else {
            // tidak ada data yang masuk dari request
            return $this->respond([
                'status' => 'failed',
                'messages' => 'provide an id!'
            ], 404);
        }
    }



    public function deleteSiswa($id = null)
    {
        if(!$id) {
            // tampung siapa tau dari body
            $datainput = $this->request->getRawInput();
            $id = $datainput['id'];
        }

        if(!$id) {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'provide an id!'
            ], 400);
        } else {
            $cari = $this->modeldatasiswa->getDataSiswa($id);

            if(!$cari) {
                // id ga ada
                return $this->respond([
                    'status' => 'failed',
                    'messages' => 'id not found ' . $id
                ], 404);
            } else {
                // id ditemukan
                $this->modeldatasiswa->delete($id);
                return $this->respondDeleted([
                    'status' => 'success',
                    'messages' => 'success deleted with id ' . $id
                ], 202);
            }
        }
    }
}
