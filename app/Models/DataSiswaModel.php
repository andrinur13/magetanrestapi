<?php

namespace App\Models;

use CodeIgniter\Model;

class DataSiswaModel extends Model
{
    protected $table = 'data_siswa';
    protected $useTimestamps = true;
    protected $primaryKey = 'id_data_siswa';
    protected $allowedFields = ['id_data_siswa', 'nisn', 'nik', 'nama', 'jenis_kelamin', 'kelas', 'jurusan', 'tahun_lulus', 'tgl_lahir', 'alamat', 'lulus', 'skhu', 'ijazah'];
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $useSoftDeletes = true;


    // get data siswa
    public function getDataSiswa($id_data_siswa = false)
    {
        if ($id_data_siswa == false) {
            return $this->findAll();
        } else {
            return $this->find($id_data_siswa);
        }
    }


    public function storeDataSiswa($data)
    {
        if ($this->insert($data)) {
            return true;
        } else {
            return false;
        }
    }


    public function updateDataSiswa($data, $id)
    {
        if ($this->update($id, $data)) {
            return true;
        } else {
            return false;
        }
    }



    public function deleteDataSiswa($id)
    {
        return $this->delete($id);
    }
}
