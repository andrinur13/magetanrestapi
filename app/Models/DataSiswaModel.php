<?php

namespace App\Models;
use CodeIgniter\Model;

class DataSiswaModel extends Model
{
    protected $table = 'data_siswa';
    protected $useTimestamps = true;
    protected $primaryKey = 'id_data_siswa';
    protected $allowedFields = ['id_data_siswa', 'nisn', 'nik', 'nama', 'tgl_lahir', 'alamat', 'lulus'];
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


    // get data siswa
    public function getDataSiswa($id_data_siswa = false)
    {
        if($id_data_siswa == false) {
            return $this->findAll();
        } else {
            return $this->find($id_data_siswa);
        }
    }


    public function storeDataSiswa($data) {
        if($this->insert($data)) {
            return true;
        } else {
            return false;
        }
    }


    public function updateDataSiswa($data, $id) {
        if($this->update($id, $data)) {
            return true;
        } else {
            return false;
        }
    }
}
