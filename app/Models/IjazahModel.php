<?php

namespace App\Models;

use CodeIgniter\Model;

class IjazahModel extends Model
{

    protected $table = 'ijazah';
    protected $useTimestamps = true;
    protected $primaryKey = 'id_ijazah';
    protected $allowedFields = ['id_data_siswa', 'link_ijazah'];

    public function getIjazah($id = false)
    {
        if($id == false) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }



    public function storeIjazah($data)
    {
        return $this->insert($data);
    }




    public function editIjazah($data, $id)
    {
        return $this->update($id, $data);
    }



    public function deleteIjazah($id)
    {
        $this->delete($id);
    }
}
