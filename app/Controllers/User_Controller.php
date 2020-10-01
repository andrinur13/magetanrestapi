<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;

class User_Controller extends ResourceController
{
    protected $modeluser;

    public function __construct()
    {
        $this->modeluser = new UserModel();

    }


    public function index()
    {
        $cari = $this->modeluser->getUser();

        if ($cari == null) {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'failed get data user'
            ], 404);
        } else {
            return $this->respond([
                'status' => 'success',
                'data' => $cari
            ], 200);
        }
    }



    public function userid()
    {
        // request dengan params;
        $id = $this->request->getVar('id');

        if ($id == null) {
            $inputan = $this->request->getRawInput();
            if (isset($inputan['id'])) {
                $id = $inputan['id'];
            }
        }

        if (!$id) {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'provide an id'
            ], 400);
        } else {
            $hasil = $this->modeluser->getUser($id);

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


    public function username()
    {
        $username = $this->request->getVar('username');

        if (!isset($username)) {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'provide an username'
            ], 400);
        } else {
            // jika ada inputan username
            $cari = $this->modeluser->getUsername($username);

            if ($cari == null) {
                return $this->respond([
                    'status' => 'failed',
                    'messages' => 'username not found!'
                ], 404);
            } else {
                return $this->respond([
                    'status' => 'success',
                    'data' => $cari
                ], 200);
            }
        }
    }


    public function createUser()
    {
        helper('form');

        $rules = [
            'id_user_type' => 'required|in_list[1, 2, 3]',
            'username' => 'required|is_unique[user.username]',
            'name' => 'required',
            'email' => 'required|valid_email',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            return $this->respond([
                'status' => 'failed',
                'errors' => $validation->getErrors()
            ], 400);
        }

        // tampung data inputan
        $datainputan = [
            'id_user_type' => $this->request->getPost('id_user_type'),
            'username' => $this->request->getPost('username'),
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ];

        $this->modeluser->storeUser($datainputan);

        return $this->respond([
            'status' => 'success',
            'messages' => 'success added data'
        ], 202);
    }


    public function editUser()
    {
        $datainput = $this->request->getRawInput();
        if (isset($datainput['id'])) {
            $id = $datainput['id'];

            $cari = $this->modeluser->getUser($id);

            if ($cari == null) {
                return $this->respond([
                    'status' => 'failed',
                    'messages' => 'id ' . $id . ' not found!'
                ], 404);
            } else {
                // jika data ditemukan

                $datahasiledit = [
                    'id_user_type' => isset($datainput['id_user_type']) ? $datainput['id_user_type'] : $cari['id_user_type'],
                    'username' => isset($datainput['username']) ? $datainput['username'] : $cari['username'],
                    'name' => isset($datainput['name']) ? $datainput['name'] : $cari['name'],
                    'email' => isset($datainput['email']) ? $datainput['email'] : $cari['email'],
                    'password' => isset($datainput['password']) ? $datainput['password'] : $cari['password'],

                ];

                if ($this->modeluser->editUser($datahasiledit, $id)) {
                    return $this->respondUpdated([
                        'status' => 'success',
                        'messages' => 'success update data'
                    ], 202);
                } else {
                    return $this->respond([
                        'status' => 'failed',
                        'messages' => 'failed to update data'
                    ], 400);
                }
            }
        } else {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'provide an id!'
            ], 400);
        }
    }


    public function deleteUser()
    {
        $datainput = $this->request->getRawInput();
        if (isset($datainput['id'])) {
            $id = $datainput['id'];

            $cari = $this->modeluser->getUser($id);

            if ($cari == null) {
                return $this->respond([
                    'status' => 'failed',
                    'messages' => 'id ' . $id . ' not found!'
                ], 404);
            } else {
                // delete data with id
                $this->modeluser->deleteUser($id);
                return $this->respondDeleted([
                    'status' => 'success',
                    'messages' => 'success delete data with id ' . $id
                ], 202);
            }
        } else {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'provide an id'
            ], 400);
        }
    }




    // JWT
    public function privateKey()
    {
        $privateKey = <<<EOD
            -----BEGIN RSA PRIVATE KEY-----
            MIICXAIBAAKBgQC8kGa1pSjbSYZVebtTRBLxBz5H4i2p/llLCrEeQhta5kaQu/Rn
            vuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t0tyazyZ8JXw+KgXTxldMPEL9
            5+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4ehde/zUxo6UvS7UrBQIDAQAB
            AoGAb/MXV46XxCFRxNuB8LyAtmLDgi/xRnTAlMHjSACddwkyKem8//8eZtw9fzxz
            bWZ/1/doQOuHBGYZU8aDzzj59FZ78dyzNFoF91hbvZKkg+6wGyd/LrGVEB+Xre0J
            Nil0GReM2AHDNZUYRv+HYJPIOrB0CRczLQsgFJ8K6aAD6F0CQQDzbpjYdx10qgK1
            cP59UHiHjPZYC0loEsk7s+hUmT3QHerAQJMZWC11Qrn2N+ybwwNblDKv+s5qgMQ5
            5tNoQ9IfAkEAxkyffU6ythpg/H0Ixe1I2rd0GbF05biIzO/i77Det3n4YsJVlDck
            ZkcvY3SK2iRIL4c9yY6hlIhs+K9wXTtGWwJBAO9Dskl48mO7woPR9uD22jDpNSwe
            k90OMepTjzSvlhjbfuPN1IdhqvSJTDychRwn1kIJ7LQZgQ8fVz9OCFZ/6qMCQGOb
            qaGwHmUK6xzpUbbacnYrIM6nLSkXgOAwv7XXCojvY614ILTK3iXiLBOxPu5Eu13k
            eUz9sHyD6vkgZzjtxXECQAkp4Xerf5TGfQXGXhxIX52yH+N2LtujCdkQZjXAsGdm
            B2zNzvrlgRmgBrklMTrMYgm1NPcW+bRLGcwgW2PTvNM=
            -----END RSA PRIVATE KEY-----
            EOD;
        return $privateKey;
    }



    public function login()
    {
        $username      = $this->request->getPost('username');
        $password   = $this->request->getPost('password');

        $cek_login = $this->modeluser->cek_login($username);


        // var_dump($cek_login);
        // die;

        // var_dump($cek_login['password']);

        if (password_verify($password, $cek_login['password'])) {
            $secret_key = $this->privateKey();
            $issuer_claim = "THE_CLAIM"; // this can be the servername. Example: https://domain.com
            $audience_claim = "THE_AUDIENCE";
            $issuedat_claim = time(); // issued at
            $notbefore_claim = $issuedat_claim + 10; //not before in seconds
            $expire_claim = $issuedat_claim + 3600; // expire time in seconds
            $token = array(
                "iss" => $issuer_claim,
                "aud" => $audience_claim,
                "iat" => $issuedat_claim,
                "nbf" => $notbefore_claim,
                "exp" => $expire_claim,
                "data" => array(
                    "id_user" => $cek_login['id_user'],
                    'id_user_type' => $cek_login['id_user_type'],
                    "username" => $cek_login['username'],
                    "name" => $cek_login['name'],
                    "email" => $cek_login['email']
                )
            );

            $token = JWT::encode($token, $secret_key);

            $output = [
                'status' => 200,
                'message' => 'Berhasil login',
                "token" => $token,
                "username" => $username,
                "expireAt" => $expire_claim
            ];
            return $this->respond($output, 200);
        } else {
            $output = [
                'status' => 401,
                'message' => 'Login failed',
                "password" => $password
            ];
            return $this->respond($output, 401);
        }
    }


    public function logintest()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $cari = $this->modeluser->getUsername($username);

        if($cari == null) {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'failed to login. user not found!'
            ]);
        } else {
            // cek password
            if(password_verify($password, $cari[0]['password'])) {
                $key_data = password_hash(serialize($cari), PASSWORD_DEFAULT);
                $cocok = password_verify(serialize($cari), $key_data);
                return $this->respond([
                    'status' => 'success',
                    'messages' => 'success login!',
                    'key' => $key_data
                ]);
            } else {
                return $this->respond([
                    'status' => 'failed',
                    'messages' => 'failed to login. wrong password!'
                ]);
            }
        }

        $cari_encrypt = password_hash(serialize($cari), PASSWORD_DEFAULT);
    }
}
