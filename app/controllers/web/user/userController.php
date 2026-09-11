<?php

use function PHPSTORM_META\type;

require_once __DIR__ . "/../../controller.php";
require_once __DIR__ . "/../../../models/profile/profileModel.php";
require_once __DIR__ . "/../../../models/user/UserModel.php";

class userController extends controller
{
    public function editUser()
    {
        $type = Request::input('inputName');

        $validTypes = ['name', 'email', 'phone', 'gender', 'password'];

        if (!in_array($type, $validTypes)) {
            return Response::json(null, 'Invalid input name');
        }

        $data = match ($type) {
            'name' => $this->editName(),
            'email' => $this->editEmail(),
            'gender' => $this->editGender(),
            'phone' => $this->editPhone(),
            'password' => $this->editPassword(),
            default => null
        };

        if ($data === null) {
            Response::json([], "invalid input name", 422);
        }

        Response::json($data, "Your {$type} update successfully");
    }

    public function editName()
    {
        $error = Request::validate([
            'name' => ['required']
        ]);

        if (!empty($error)) {
            Response::json([], "name is required", 422);
        }

        $_SESSION['user']['name'] = Request::input('name');
        $_SESSION['_old'] = [];
        UserModel::editUser('name', Request::input('name'));
        return ["name" => Request::input('name')];
    }

    public function editEmail()
    {
        $error = Request::validate([
            'email' => ['required', 'email', ['unique', 'users', auth('id')]]
        ]);

        if (!empty($error)) {
            Response::json([], $error['email'][0], 422);
        }

        $_SESSION['user']['email'] = Request::input('email');
        $_SESSION['_old'] = [];
        UserModel::editUser('email', Request::input('email'));
        return ["email" => Request::input('email')];
    }

    public function editGender()
    {
        $error = Request::validate([
            'gender' => ['required']
        ]);

        if (!empty($error)) {
            Response::json([], $error['gender'][0], 422);
        }

        $_SESSION['user']['gender'] = Request::input('gender');
        $_SESSION['_old'] = [];
        UserModel::editUser('gender', Request::input('gender'));
        return ["gender" => Request::input('gender')];
    }
    public function editPhone()
    {
        $error = Request::validate([
            'phone' => ['required', 'EGPhone', ['unique', 'users', auth('id')]]
        ]);

        if (!empty($error)) {
            Response::json([], $error['phone'][0], 422);
        }

        $_SESSION['user']['phone'] = Request::input('phone');
        $_SESSION['_old'] = [];
        UserModel::editUser('phone', Request::input('phone'));
        return ["phone" => Request::input('phone')];
    }
    public function editPassword()
    {
        $error = Request::validate([
            'password' => ['required', ['min', 8]]
        ]);

        if (!empty($error)) {
            Response::json([], $error['password'][0], 422);
        }

        $_SESSION['user']['password'] = Request::input('password');
        $_SESSION['_old'] = [];
        UserModel::editUser('password', Request::input('password'));
        return ["password" => Request::input('password')];
    }


    public function  toggleBanUser()
    {
        $errors = Request::validate([
            "user_id" => ['required', ['exists', "users", "id"]]
        ]);

        if (!empty($errors)) {
            Response::json($errors, status: 422);
        }

        $userId = Request::input('user_id');
        $role = UserModel::getRoleOfUser($userId);

        if ($role == 'admin' && auth('id') > $userId) {
            Response::json(null, "You don't have permission to perform this action.", 403);
        }

        $isban = UserModel::toggleBanUser();
        $msg = $isban ? 'banned' : 'unbanned';
        Response::json([$isban], "The User has been {$msg} successfully");
    }
}
