<?php
require_once __DIR__ . "/../../controller.php";
require_once __DIR__ . "/../../../models/auth/AuthModel.php";

class loginController extends controller
{
    public function  index()
    {
        $this->view("auth/login");
    }

    public function  login()
    {
        $errors = Request::validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($errors) {
            back();
        }

        $data = AuthModel::login();

        if ($data['is_banned']) {
            $_SESSION['_old'] = [];
            back('bannedAccount', "Your Account is banned from admin");
        }

        if ($data != false) {
            session_regenerate_id(true);
            $_SESSION['user'] = $data;
            $_SESSION['_old'] = [];
            redirect('/profile');
        }

        back('invalidAccount', "incorrect Email or Password");
    }

    public function logout()
    {
        unset($_SESSION['user']);
        session_regenerate_id(true);
        redirect('/auth/login');
    }
}
