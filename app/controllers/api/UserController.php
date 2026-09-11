<?php

require_once __DIR__ . "/../../models/user/UserModel.php";

class UserController
{
    public function getUsers()
    {
        // $users = [
        //     ["id" => 4, "name" => "Ahmed mohamed"],
        //     ["id" => 4, "name" => "Ahmed mohamed"],
        //     ["id" => 4, "name" => "Ahmed mohamed"]
        // ];


        $userModel = new UserModel();
        $users = $userModel->getUsers();

        echo json_encode([
            "message" => "Successfully",
            "data" => $users
        ]);

        // Response::json($users, "successfully");
    }
}
