<?php

require_once __DIR__ . "/../controller.php";

class HomeController extends controller
{
    public function index(string $product = '', string $item = '')
    {
        $data = [
            'userName' => "Ahmed",
            'product' => $product,
            'item' => $item
        ];

        $this->view("Home/home", $data);
    }
    // public function test()
    // {
    //     $errors = Request::validate([
    //         'email' => ["required" , "email"],
    //         'password' => ["required", ["min", 8]],
    //     ]);

    //     $this->view("Home/home");
    // }
}
