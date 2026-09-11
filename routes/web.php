<?php

require_once __DIR__ . "/../core/Route.php";
require_once __DIR__ . "/../app/controllers/web/homeController.php";
require_once __DIR__ . "/../app/controllers/web/auth/loginController.php";
require_once __DIR__ . "/../app/controllers/web/auth/registerController.php";
require_once __DIR__ . "/../app/controllers/web/profile/profileController.php";
require_once __DIR__ . "/../app/controllers/web/user/userController.php";
require_once __DIR__ . "/../app/controllers/web/author/AuthorController.php";
require_once __DIR__ . "/../app/controllers/web/book/BooKController.php";
require_once __DIR__ . "/../app/controllers/web/order/OrderController.php";
require_once __DIR__ . "/../app/middlewares/AuthMiddleware.php";
require_once __DIR__ . "/../app/middlewares/GuestMiddleware.php";
require_once __DIR__ . "/../app/middlewares/RegisterMiddleware.php";

Route::get("", HomeController::class, "index");

Route::get("/auth/login", loginController::class, "index", [GuestMiddleware::class]);
Route::post("/auth/login", loginController::class, "login");
Route::get("/auth/logout", loginController::class, "logout", [AuthMiddleware::class]);

Route::get("/auth/register", registerController::class, "index", [RegisterMiddleware::class]);
Route::post("/auth/register", registerController::class, "register", [RegisterMiddleware::class]);


Route::get("/profile", profileController::class, "index", [AuthMiddleware::class]);
Route::post("/profile/getData", profileController::class, "getData", [AuthMiddleware::class]);

Route::post("/profile/filterBooks", BookController::class, "filterBooks", [AuthMiddleware::class]);


Route::post("/profile/editUser", userController::class, "editUser", [AuthMiddleware::class]);
Route::post("/profile/getitemsIntoCart", OrderController::class, "getitemsIntoCart", [AuthMiddleware::class]);

/* ========== Admin ========= */
Route::post("/profile/addAuthor", AuthorController::class, "addAuthor", ["AuthMiddleware:admin"]);
Route::post("/profile/addBook", BookController::class, "addBook", ["AuthMiddleware:admin"]);
Route::post("/profile/toggleBanUser", userController::class, "toggleBanUser", ["AuthMiddleware:admin"]);
Route::post("/profile/changeStatusOfOrder", OrderController::class, "changeStatusOfOrder", ["AuthMiddleware:admin"]);


/* ========== Customer ========== */
Route::post("/profile/orderBook", OrderController::class, "orderBook", ["AuthMiddleware:customer"]);
Route::post("/profile/changeQuantity", OrderController::class, "changeQuantity", ["AuthMiddleware:customer"]);
Route::post("/profile/deleteOrderItem", OrderController::class, "deleteOrderItem", ["AuthMiddleware:customer"]);
Route::post("/profile/orderNow", OrderController::class, "orderNow", ["AuthMiddleware:customer"]);
