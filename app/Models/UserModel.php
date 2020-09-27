<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{

    protected $table = 'user';
    protected $useTimestamps = true;
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['id_user_type', 'username', 'name', 'email', 'password'];
    protected $useSoftDeletes = true;
    // protected $builder;

    public function __construct()
    {

        
    }

    public function getUser($id = null)
    {
        if ($id == null) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }

    public function getUsername($username)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('user');

        if (!$username) {
            return null;
        } else {
            return $builder->getWhere(['username' => $username])->getResultArray();
        }
    }

    public function storeUser($data)
    {
        $this->insert($data);
    }

    public function editUser($data, $id)
    {
        $this->update($id, $data);
    }

    public function deleteUser($id)
    {
        $this->delete($id);
    }


    // jwt access
    public function cek_login($username)
    {
        $query = $this->table($this->table)
            ->where('username', $username)
            ->countAll();

        if ($query >  0) {
            $hasil = $this->table($this->table)
                ->where('username', $username)
                ->limit(1)
                ->get()
                ->getRowArray();
        } else {
            $hasil = array();
        }
        return $hasil;
    }
}
