<?php

class App
{
    public static function run()
    {
        session_start();
        $url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $typeRequest = str_starts_with($url, BASE_URL . "/api") ? "api" : "web";

        if ($typeRequest === "api") {
            header('Content-Type: application/json; charset=UTF-8');
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, Authorization');
        }

        require_once __DIR__ . "/../routes/{$typeRequest}.php";
        require_once __DIR__ . "/Route.php";
        require_once __DIR__ . "/../app/helpers/helpers.php";
        require_once __DIR__ . "/../core/Response.php";
        require_once __DIR__ . "/../core/Request.php";
        require_once __DIR__ . "/../core/validation.php";
        
        Route::dispatch();
    }
}
