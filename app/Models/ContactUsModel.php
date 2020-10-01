<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactUsModel extends Model
{
    protected $table = 'contact_us';
    protected $useTimestamps = true;
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'subject', 'messages'];
    protected $useSoftDeletes = true;

    public function getData($id = null)
    {
        if($id == null) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }

    public function storeData($data)
    {
        $this->insert($data);
    }


    public function updateData($data, $id)
    {
        $this->update($id, $data);
    }


    public function deleteData($id)
    {
        $this->delete($id);
    }


}