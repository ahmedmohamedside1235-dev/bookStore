<?php

require_once __DIR__ . "/../../controller.php";
require_once __DIR__ . "/../../../models/profile/profileModel.php";
require_once __DIR__ . "/../../../models/book/BookModel.php";
require_once __DIR__ . "/../../../models/order/OrderModel.php";

class profileController extends controller
{
    public function  index()
    {
        $data = null;

        if (isAuth('admin'))
            $data = $this->getAdminData();
        else
            $data = $this->getCustomerData();

        // prArr($data, true);
        $this->view('/Profile/profile', $data);
    }

    private function getCustomerData()
    {
        $total = [
            'totalBooks' => profileModel::getTotalOfTable("books"),
            'totalBoughtBooks' => profileModel::getTotalBoughtBooks(),
            'totalitemsIntoCart' => OrderModel::totalItmesIntoOrder(),
            'orders' => [
                'ordered' => profileModel::getTotalOfTable(
                    "orders",
                    [
                        ['customer_id', '=', auth('id')],
                        ['status', '=', 'ordered'],
                    ]
                ),
                'canceled' => profileModel::getTotalOfTable(
                    "orders",
                    [
                        ['customer_id', '=', auth('id')],
                        ['status', '=', 'canceled'],
                    ]
                ),
                'done' => profileModel::getTotalOfTable("orders", [
                    ['customer_id', '=', auth('id')],
                    ['status', '=', 'done'],
                ])
            ]
        ];

        $books = BookModel::getDataOfBooks();

        $ordered = OrderModel::getDataOfOrders([
            ['customer_id', '=', auth('id')],
            ['status', '=', 'ordered']
        ]);
        $canceled = OrderModel::getDataOfOrders([
            ['customer_id', '=', auth('id')],
            ['status', '=', 'canceled']
        ]);
        $done = OrderModel::getDataOfOrders([
            ['customer_id', '=', auth('id')],
            ['status', '=', 'done']
        ]);

        $data = [
            'Books' => $books,
            'Orders_ordered' => $ordered,
            'Orders_canceled' => $canceled,
            'Orders_done' => $done,
        ];

        return [
            'total' => $total,
            'data' => $data
        ];
    }
    private function getAdminData()
    {
        $total = [
            'totalBooks' => profileModel::getTotalOfTable("books"),
            'totalAuthors' => profileModel::getTotalOfTable("authors"),
            'totalCustomers' => profileModel::getTotalOfTable("users", [['role', '=', 'customer']]),
            'totalAdmins' => profileModel::getTotalOfTable("users", [['role', '=', 'admin']]),
            'orders' => [
                'ordered' => profileModel::getTotalOfTable("orders", [['status', '=', 'ordered']]),
                'canceled' => profileModel::getTotalOfTable("orders", [['status', '=', 'canceled']]),
                'done' => profileModel::getTotalOfTable("orders", [['status', '=', 'done']])
            ]
        ];

        $admins = profileModel::getDataOfTable("users", [['role', '=', 'admin'], ['id', '!=', auth('id')]]);
        $customers = profileModel::getDataOfTable("users", [['role', '=', 'customer']]);
        $authors = profileModel::getDataOfTable("authors");
        $books = BookModel::getDataOfBooks();

        $ordered = OrderModel::getDataOfOrders([['status', '=', 'ordered']]);
        $canceled = OrderModel::getDataOfOrders([['status', '=', 'canceled']]);
        $done = OrderModel::getDataOfOrders([['status', '=', 'done']]);

        $data = [
            'Admins' => $admins,
            'Customers' => $customers,
            'Books' => $books,
            'Authors' => $authors,
            'Orders_ordered' => $ordered,
            'Orders_canceled' => $canceled,
            'Orders_done' => $done,
        ];

        return [
            'total' => $total,
            'data' => $data
        ];
    }

    public function getData()
    {
        $errors = Request::validate([
            'typeData' => ['required'],
            'except' => ['required']
        ]);

        if (!empty($errors)) {
            Response::json($errors, status: 422);
        }

        $pageNumber = (int)(Request::input('pageNumber', 1));
        $type = Request::input('typeData', 'Admins');

        $data = match ($type) {
            'Admins'           => $this->getAdmins($pageNumber),
            'Customers'        => $this->getCustomers($pageNumber),
            'Books'            => $this->getBooks($pageNumber),
            'Authors'          => $this->getAuthors($pageNumber),
            'Orders_ordered'   => $this->getOrders('ordered', $pageNumber),
            'Orders_canceled'  => $this->getOrders('canceled', $pageNumber),
            'Orders_done'      => $this->getOrders('done', $pageNumber),
            default            => null,
        };

        if ($data === null) {
            return Response::json(null, 'Invalid typeData');
        }

        Response::json($data, 'successfully');
    }

    public function getAdmins(int $adminsPage)
    {
        $admins = profileModel::getDataOfTable("users", [['role', '=', 'admin'], ['id', '!=', auth('id')]], page: $adminsPage);
        return [
            'Admins' => $admins
        ];
    }

    public function getCustomers(int $customersPage)
    {
        $customers = profileModel::getDataOfTable("users", [['role', '=', 'customer']], page: $customersPage);
        return [
            'Customers' => $customers
        ];
    }

    public function getBooks(int $booksPage)
    {
        $books = BookModel::getDataOfBooks(page: $booksPage);
        return [
            'Books' => $books
        ];
    }

    public function getAuthors(int $authorsPage)
    {
        $authors = profileModel::getDataOfTable("authors", page: $authorsPage);
        return [
            'Authors' => $authors
        ];
    }

    public function getOrders(string $status, int $page)
    {
        $rules = [['status', '=', $status]];
        $except = Request::input('except');
        $except = filter_var($except, FILTER_VALIDATE_BOOLEAN);

        if ($except) {
            $rules[] = ['customer_id', '=', auth('id')];
        }

        return ["Orders_{$status}" => OrderModel::getDataOfOrders($rules, $page)];
    }
}
