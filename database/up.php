<?php

require_once __DIR__ . "/create_users_tables.php";
require_once __DIR__ . "/create_authors_tables.php";
require_once __DIR__ . "/create_books_tables.php";
require_once __DIR__ . "/create_orders_tables.php";
require_once __DIR__ . "/create_order_items_tables.php";
require_once __DIR__ . "/create_api_tokens_tables.php";


create_users_tables::up();
create_authors_tables::up();
create_books_tables::up();
create_orders_tables::up();
create_order_items_tables::up();
create_api_tokens_tables::up();