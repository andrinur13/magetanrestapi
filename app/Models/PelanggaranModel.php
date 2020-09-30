<?php

namespace App\Models;

use CodeIgniter\Model;

class PelanggaranModel extends Model
{

    protected $table = 'pelanggaran';
    protected $useTimestamps = true;
    protected $primaryKey = 'id_pelanggaran';
    protected $allowedFields = ['id_data_siswa', 'jenis', 'nama_pelanggaran', 'hukuman'];
    protected $useSoftDeletes = true;



    public function getPelanggaran($id = null)
    {
        if ($id == null) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }

    public function getPelanggaranDataSiswa($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pelanggaran');

        if (!$id) {
            return null;
        } else {
            return $builder->getWhere(['id_data_siswa' => $id])->getResultArray();
        }
    }

    public function storePelanggaran($data)
    {
        $this->insert($data);
    }

    public function editPelanggaran($data, $id)
    {
        if($this->update($id, $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function deletePelanggaran($id)
    {
        $this->delete($id);
    }
}
