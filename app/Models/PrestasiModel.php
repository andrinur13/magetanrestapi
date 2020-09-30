<?php

namespace App\Models;

use CodeIgniter\Model;

class PrestasiModel extends Model
{

    protected $table = 'prestasi';
    protected $useTimestamps = true;
    protected $primaryKey = 'id_prestasi';
    protected $allowedFields = ['id_data_siswa', 'tingkat', 'penyelenggara', 'nama_kegiatan', 'hasil', 'piagam'];
    protected $useSoftDeletes = true;

    

    public function getPrestasi($id = false)
    {

        if ($id == false) {
            // jika id tidak ada
            // maka kembalikan semua data prestasi
            return $this->findAll();
        } else {
            // id ada
            return $this->find($id);
        }
    }


    public function storePrestasi($data)
    {
        return $this->insert($data);
    }


    public function updatePrestasi($data, $id) {
        $this->update($id, $data);
    }


    public function deletePrestasi($id) {
        $this->delete($id);
    }
}
