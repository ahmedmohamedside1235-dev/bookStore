<?php

require_once __DIR__ . "/../../controller.php";
require_once __DIR__ . "/../../../models/book/BookModel.php";
require_once __DIR__ . "/../../../models/Model.php";


class BooKController extends controller
{
    public function filterBooks()
    {
        $pageNumber = Request::input('pageNumber', 1);
        $minPrice = Request::input('minPrice', "") == "" ? 0 : (int)Request::input('minPrice');
        $stock = Request::input('stock', '') == "" ? null : Request::input('stock');
        $maxPrice = Request::input('maxPrice', '') == "" ? null : (int)Request::input('maxPrice');
        $where = [
            ['authors.name', 'LIKE', "%" . Request::input('author', '') . "%"],
            ['books.title', 'LIKE', '%' . Request::input('title', '') . '%'],
            ['books.price', ">=", $minPrice],
        ];


        if ($maxPrice != null) {
            array_push($where, ['books.price', "<=", $maxPrice]);
        }

        if ($stock != null) {
            array_push($where, ['books.stock', '=', $stock]);
        }

        Response::json(BookModel::getDataOfBooks($where, Request::input('sort', "DESC"), $pageNumber));
    }

    public function addBook()
    {
        $errors = Request::validate([
            'authorId' => ['required', ['exists', 'authors', 'id']],
            'title' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
            'stock' => ['required'],
        ]);

        if (!empty($errors)) {
            Response::json($errors, status: 422);
        }

        $book = BookModel::addBook();
        Response::json($book, "The Book has been Added successfully");
    }
}
