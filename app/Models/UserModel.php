<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{

    protected $table = 'user';
    protected $useTimestamps = true;
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['id_user_type', 'name', 'email', 'password'];
    protected $useSoftDeletes = true;

    public function getUser($id = null)
    {
        if ($id == null) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }

    public function storeUser($data)
    {
        $this->insert($data);
    }

    public function editUser($data, $id)
    {
        if($this->update($id, $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteUser($id)
    {
        $this->delete($id);
    }
}
