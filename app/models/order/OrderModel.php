<?php

require_once __DIR__ . "/../Model.php";
require_once __DIR__ . "/../../../core/Database.php";

class OrderModel extends Model
{
    public static function getDataOfOrders(array $wheres = [], int $page = 1)
    {
        $DB = Database::getConnection();
        $offset = ($page * 10) - 10;
        $queryWheres = Model::prepareWhereQuery($wheres);
        $data = $DB->query("SELECT 
                                orders.*,
                                users.name AS customer_name
                                FROM orders
                                LEFT JOIN users ON users.id = orders.customer_id
                                {$queryWheres}
                                ORDER BY id DESC
                                LIMIT 10 OFFSET $offset
                            ");
        $count = $DB->query("SELECT COUNT(*) AS total  
                                FROM orders
                                LEFT JOIN users ON users.id = orders.customer_id 
                                {$queryWheres}");
        return [
            "data" => $data->fetchAll(),
            "count" => ceil(($count->fetch()['total'] / 10)),
            "currentPage" => $page
        ];
    }

    private static function getPendingOrderID(): false | int
    {
        $DB = Database::getConnection();
        $authId = auth('id');
        $stmt = $DB->query("SELECT id FROM orders WHERE customer_id = {$authId} AND status = 'pending'");
        return $stmt->fetchColumn();
    }

    private static function updateTotalPriceOfOrder()
    {
        $DB = Database::getConnection();
        $orderId = self::getPendingOrderID();
        $totalPrice = $DB->query("SELECT COALESCE(SUM(subtotal), 0) AS total FROM orders_items WHERE order_id = {$orderId};")->fetchColumn();
        $DB->exec("UPDATE orders SET total_price = {$totalPrice} WHERE id = {$orderId};");
        return $totalPrice;
    }

    public static function totalItmesIntoOrder()
    {
        $DB = Database::getConnection();
        $orderId = self::getPendingOrderID();

        if ($orderId === false)
            return 0;

        $totalOrders = $DB->query("SELECT COUNT(*) AS total FROM orders_items WHERE order_id = {$orderId};")->fetchColumn();
        return $totalOrders === false ? 0 : $totalOrders;
    }

    private static function getOrderItemID(string $orderId, string $bookId)
    {
        $DB = Database::getConnection();
        $stmt = $DB->query("SELECT id FROM orders_items WHERE order_id = '{$orderId}' AND book_id = '{$bookId}'");
        return $stmt->fetchColumn();
    }

    public static function orderBook()
    {
        $DB = Database::getConnection();
        $pendingOrderID = self::getPendingOrderID();
        $authId = auth('id');

        if ($pendingOrderID === false) {
            // create a new order
            $DB->exec("INSERT INTO orders (customer_id) VALUES ('{$authId}')");
            $pendingOrderID = $DB->lastInsertId();
        }

        $quantity = Request::input('quantity');
        $bookId = Request::input('book_id');
        $orderItemId = self::getOrderItemID($pendingOrderID, $bookId);
        $unitPrice = $DB->query("SELECT price FROM books WHERE id = '{$bookId}'")->fetchColumn();

        if ($orderItemId === false) {
            $stmt = $DB->prepare("INSERT INTO orders_items 
                    (order_id , book_id , quantity , unit_price , subtotal)
                    VALUES
                    (:order_id , :book_id , :quantity , :unit_price , :subtotal);
                    ");

            $stmt->execute([
                "order_id" => $pendingOrderID,
                "book_id" => $bookId,
                "quantity" => $quantity,
                "unit_price" => $unitPrice,
                "subtotal" => (float)$unitPrice * (int)$quantity
            ]);
        } else {
            $newSubTotal = $quantity * $unitPrice;
            $DB->exec("UPDATE orders_items 
                        SET
                        quantity = quantity + {$quantity},
                        subtotal = subtotal + {$newSubTotal}
                        WHERE id = {$orderItemId}
                        ");
        }

        self::updateStock('-', $quantity);
        self::updateTotalPriceOfOrder();
        return self::totalItmesIntoOrder();
    }

    public static function getitemsIntoCart(?int $orderId = null)
    {
        $DB = Database::getConnection();

        if ($orderId == null)
            $orderId = self::getPendingOrderID();

        if ($orderId == null) {
            return [];
        }

        $items = $DB->query("SELECT
                                books.id AS book_id,
                                books.title,
                                books.image,
                                books.description,
                                books.price,
                                books.stock,
                                authors.id AS author_id,
                                authors.name AS author_name,
                                orders.id AS order_id,
                                orders.total_price,
                                orders_items.id AS orders_items_id,
                                orders_items.quantity,
                                orders_items.subtotal
                                FROM orders_items 
                                LEFT JOIN orders ON orders.id = orders_items.order_id
                                LEFT JOIN books ON books.id = orders_items.book_id
                                LEFT JOIN authors ON authors.id = books.author_id
                                WHERE 
                                    orders.id = {$orderId}
                                ;")->fetchAll();
        return $items;
    }

    public static function checkValidStock(?string $quantityValue = null): bool
    {
        $DB = Database::getConnection();
        $stmt = $DB->prepare('SELECT stock FROM books WHERE id = :bookId');
        $stmt->execute([
            'bookId' => Request::input('book_id')
        ]);

        $stock = $stmt->fetchColumn();

        if ($stock === false) {
            return false;
        }

        $quantity = Request::input('quantity', $quantityValue);

        if ($quantity === null || !is_numeric($quantity) || (int)$quantity <= 0) {
            return false;
        }

        return (int)$stock >= (int)$quantity;
    }

    public static function checkIsStockEmpty(): bool
    {
        $DB = Database::getConnection();
        $stmt = $DB->prepare('SELECT stock FROM books WHERE id = :bookId');
        $stmt->execute([
            'bookId' => Request::input('book_id')
        ]);

        $stock = $stmt->fetchColumn();

        if ($stock === false) {
            return false;
        }

        return (int)$stock <= 0;
    }

    public static function updateStock(string $operationStock, int $value = 1)
    {
        $DB = Database::getConnection();
        $stmt = $DB->prepare("UPDATE books SET stock = stock {$operationStock} {$value} WHERE id = :bookId");
        $stmt->execute([
            'bookId' => Request::input('book_id')
        ]);

        $stmt = $DB->prepare("SELECT stock FROM books WHERE id = :bookId;");
        $stmt->execute([
            "bookId" => Request::input('book_id'),
        ]);

        return $stmt->fetchColumn();
    }

    public static function changeQuantity(string $operation)
    {
        $DB = Database::getConnection();
        $bool = true;

        // check stock before increase quantity
        if ($operation == '+') {
            $stmt = $DB->prepare("SELECT * FROM orders_items WHERE id = :orderItemId;");
            $stmt->execute([
                "orderItemId" => Request::input('orderItemId'),
            ]);

            $orderItem = $stmt->fetch();

            $bool = !self::checkIsStockEmpty();
        }

        // if stock is valid
        if ($bool != false) {
            $operationStock = ($operation == '+') ? '-' : '+';

            // update stock 
            self::updateStock($operationStock);

            $stmt = $DB->prepare("UPDATE orders_items 
                                SET 
                                    quantity = quantity {$operation} 1,
                                    subtotal = subtotal {$operation} unit_price
                                WHERE id = :orderItemId;");
            $stmt->execute([
                "orderItemId" => Request::input('orderItemId'),
            ]);

            $stmt = $DB->prepare("SELECT * FROM orders_items WHERE id = :orderItemId;");
            $stmt->execute([
                "orderItemId" => Request::input('orderItemId'),
            ]);

            $orderItem = $stmt->fetch();

            if ($orderItem['quantity'] == 0 && $operation == '-')
                self::deleteOrderItems();

            $totalPrice = self::updateTotalPriceOfOrder();
            return [
                "orderItem" => $orderItem,
                "totalPrice" => $totalPrice,
                "totalOrderIntoCart" => self::totalItmesIntoOrder()
            ];
        } else {
            Response::json(null, 'The Quantity is not valid', 403);
        }
    }

    public static function deleteOrderItems()
    {
        $DB = Database::getConnection();
        $stmt = $DB->prepare("SELECT quantity FROM orders_items WHERE id = :orderItemId;");
        $stmt->execute([
            "orderItemId" => Request::input('orderItemId'),
        ]);

        $quantity = $stmt->fetchColumn();

        $stock = self::updateStock('+', $quantity);

        $stmt = $DB->prepare("DELETE FROM orders_items WHERE id = :orderItemId;");
        $stmt->execute([
            "orderItemId" => Request::input('orderItemId'),
        ]);

        return [
            "totalOrderIntoCart" => self::totalItmesIntoOrder(),
            "totalPrice" => self::updateTotalPriceOfOrder(),
            "stock" => $stock,
        ];
    }

    public static function changeStatusOfOrder(string $status, ?string $cancelReson = null)
    {
        $DB = Database::getConnection();
        $stmt = $DB->prepare("UPDATE orders 
                                SET 
                                    status = '{$status}',
                                    cancel_reason = :cancelReson
                                WHERE id = :orderId;");
        $stmt->execute([
            "orderId" => Request::input('orderId'),
            "cancelReson" => $cancelReson,
        ]);

        $stmt = $DB->prepare("SELECT users.name AS customer_name , orders.*
                            FROM orders 
                            LEFT JOIN users ON users.id = orders.customer_id
                            WHERE orders.id = :orderId;");
        $stmt->execute([
            "orderId" => Request::input('orderId'),
        ]);

        return $stmt->fetch();
    }
}
