<?php

require_once __DIR__ . "/../../controller.php";
require_once __DIR__ . "/../../../models/profile/profileModel.php";

class profileController extends controller
{
    // api function
    // public function getData()
    // {
    //     $pageNumber = 1;
    //     if (Request::input('pageNumber') !== null) {
    //         $pageNumber = Request::input('pageNumber');
    //     }
    //     $admins = profileModel::getDataOfTable("users", [['role', '=', 'admin'], ['id', '!=', auth('id')]], page: $pageNumber);
    //     $customers = profileModel::getDataOfTable("users", [['role', '=', 'customer']], page: $pageNumber);
    //     $authors = profileModel::getDataOfTable("authors", page: $pageNumber);
    //     $books = profileModel::getDataOfTable("books", page: $pageNumber);
    //     $orders = [
    //         'ordered' => profileModel::getDataOfTable("orders", [['status', '=', 'ordered']], page: $pageNumber),
    //         'canceled' => profileModel::getDataOfTable("orders", [['status', '=', 'canceled']], page: $pageNumber),
    //         'done' => profileModel::getDataOfTable("orders", [['status', '=', 'done']], page: $pageNumber)
    //     ];

    //     $data = [
    //         'admins' => $admins,
    //         'customers' => $customers,
    //         'authors' => $authors,
    //         'books' => $books,
    //         'orders' => $orders,
    //     ];
    //     Response::json($data, "successfully");
    // }
}
