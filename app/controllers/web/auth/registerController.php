<?php
require_once __DIR__ . "/../../controller.php";
require_once __DIR__ . "/../../../models/user/UserModel.php";

class registerController extends controller
{
    public function  index()
    {
        $this->view("auth/register");
    }

    public function register()
    {
        $errors = Request::validate([
            'role' => ['required'],
            'name' => ['required'],
            'email' => ['required', 'email', ['unique', 'users']],
            'password' => ['required', ['min', 8]],
            'phone' => ['required', 'EGPhone', ['unique', 'users']],
            'gender' => ['required'],
        ]);

        if ($errors) {
            back();
        }

        if (Request::input('role') === 'admin' && !isAuth('admin')) {
            back("invalid", "You Must To Login As Admin");
        }

        UserModel::createUser();
        $role = Request::input('role');
        $_SESSION['_old'] = [];
        back("correct", "New {$role} Created Successfully");
    }
}
