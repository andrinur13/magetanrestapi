<?php

namespace App\Models;

use CodeIgniter\Model;

class IjazahModel extends Model
{

    public function getIjazah($id = false)
    {
        if($id == false) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }

    

    public function createIjazah($data)
    {
        return $this->insert($data);
    }




    public function updateIjazah($data, $id)
    {
        return $this->update($id, $data);
    }



    public function deleteIjazah($id)
    {
        $this->delete($id);
    }
}
