<?php

require_once __DIR__ . "/middleware.php";

class GuestMiddleware implements middleware
{
    public function handel(): void
    {
        if (isset($_SESSION['user'])) {
            redirect("/profile");
        }
    }
}
