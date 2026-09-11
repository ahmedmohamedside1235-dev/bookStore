<?php

require_once __DIR__ . "/create_users_tables.php";
require_once __DIR__ . "/create_authors_tables.php";
require_once __DIR__ . "/create_books_tables.php";
require_once __DIR__ . "/create_orders_tables.php";
require_once __DIR__ . "/create_order_items_tables.php";
require_once __DIR__ . "/create_api_tokens_tables.php";


create_api_tokens_tables::dawn();
create_order_items_tables::dawn();
create_orders_tables::dawn();
create_books_tables::dawn();
create_authors_tables::dawn();
create_users_tables::dawn();
