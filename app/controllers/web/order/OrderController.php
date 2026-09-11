<?php

require_once __DIR__ . "/../../controller.php";
require_once __DIR__ . "/../../../models/profile/profileModel.php";
require_once __DIR__ . "/../../../models/book/BookModel.php";
require_once __DIR__ . "/../../../models/order/OrderModel.php";

class OrderController extends controller
{
    public function orderBook()
    {
        $errors = Request::validate([
            'book_id' => ['required', ["exists", 'books', 'id']],
            'quantity' => ['required', 'integer'],
        ]);

        if (!empty($errors)) {
            Response::json($errors, status: 422);
        }

        $totalOrders = OrderModel::orderBook();
        Response::json([
            'totalItmesOrders' => $totalOrders
        ], "The book has been added to your order successfully.");
    }

    public function getitemsIntoCart()
    {
        $orderId = Request::input('orderId');

        if ($orderId != null) {
            $errors = Request::validate([
                'orderId' => ['required', ['exists', 'orders', 'id']],
            ]);

            if (!empty($errors)) {
                Response::json($errors, status: 422);
            }
        }

        Response::json(OrderModel::getitemsIntoCart($orderId));
    }

    public  function changeQuantity()
    {
        $errors = Request::validate([
            'orderItemId' => ['required', ['exists', 'orders_items', 'id']],
            'typeAction' => ['required'],
        ]);

        if (!empty($errors)) {
            Response::json($errors, status: 422);
        }

        $type = Request::input('typeAction');

        $data = match ($type) {
            'increase' => OrderModel::changeQuantity('+'),
            'decrease' => OrderModel::changeQuantity('-'),
            default => null
        };

        if ($data == null) {
            Response::error('The action is not found');
        }

        Response::json($data);
    }

    public function deleteOrderItem()
    {
        $errors = Request::validate([
            'orderItemId' => ['required', ['exists', 'orders_items', 'id']],
        ]);

        if (!empty($errors)) {
            Response::json($errors, status: 422);
        }

        Response::json(OrderModel::deleteOrderItems());
    }

    public function orderNow()
    {
        $errors = Request::validate([
            'orderId' => ['required', ['exists', 'orders', 'id']],
        ]);

        if (!empty($errors)) {
            Response::json($errors, status: 422);
        }

        OrderModel::changeStatusOfOrder('ordered');
        $orders = OrderModel::getDataOfOrders([
            ['customer_id', '=', auth('id')],
            ['status', '=', 'ordered']
        ]);

        Response::json([
            "boughtBooks" => profileModel::getTotalBoughtBooks(),
            "orders" => $orders,
        ]);
    }

    public function changeStatusOfOrder()
    {
        $cancelReson = Request::input('cancelReson');

        $rules = [
            'orderId' => ['required', ['exists', 'orders', 'id']],
            'status' => ['required'],
        ];

        if ($cancelReson !== null) {
            $rules['cancelReson'] = ['required'];
        }

        $errors = Request::validate($rules);

        if (!empty($errors)) {
            Response::json($errors, status: 422);
            return;
        }

        $status = Request::input('status');

        if (!in_array($status, ['canceled', 'done'], true)) {
            Response::error('This action is forbidden.', status: 403);
            return;
        }

        $data = match ($status) {
            'canceled' => OrderModel::changeStatusOfOrder('canceled', $cancelReson),
            'done' => OrderModel::changeStatusOfOrder('done'),
            default => null
        };

        Response::json($data);
    }
}
