<?php

require_once __DIR__ . "/../../controller.php";
require_once __DIR__ . "/../../../models/author/AuthorModel.php";

class AuthorController extends controller
{
    public function addAuthor()
    {
        $errors = Request::validate([
            'name' => ['required'],
            'bio' => ['required']
        ]);

        if (!empty($errors)) {
            Response::json($errors, "Unprocessable Entity", 422);
        }

        $newAuthor = [
            'author' => AuthorModel::createAuthor(),
            'currentPage' => Request::input('page'),
            'total' => ceil(profileModel::getTotalOfTable('authors') / 10)
        ];

        Response::json($newAuthor, "New Author has been Added Successfully");
    }
}
