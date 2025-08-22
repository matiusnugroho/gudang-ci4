<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function index()
    {
        return view('auth/login');
    }

    public function login()
    {
        $session   = session();
        $userModel = new UserModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // cek user (bisa login pakai username atau email)
        $user = $userModel->where('username', $username)
                          ->orWhere('email', $username)
                          ->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                // update last_login
                $userModel->update($user['id'], [
                    'last_login' => date('Y-m-d H:i:s')
                ]);

                // set session
                $session->set([
                    'user_id'   => $user['id'],
                    'username'  => $user['username'],
                    'role'      => $user['role'],
                    'logged_in' => true,
                ]);

                return redirect()->to('/');
            } else {
                return redirect()->back()->with('error', 'Password salah!');
            }
        } else {
            return redirect()->back()->with('error', 'User tidak ditemukan!');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth');
    }
}
