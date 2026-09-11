<?php

require_once __DIR__ . "/../core/Route.php";
require_once __DIR__ . "/../app/controllers/api/profile/profileController.php";

Route::post("/api/v1/getData", profileController::class, "getData");
