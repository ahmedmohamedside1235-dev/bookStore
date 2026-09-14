<?php

require_once __DIR__ . "/../controller.php";

class HomeController extends controller
{
    public function index()
    {
        $this->view("Home/home");
    }
}
