<?php

require_once __DIR__ . "/middleware.php";

class AuthMiddleware implements middleware
{
    public function  handel(string ...$roles): void
    {
        if (!isset($_SESSION['user'])) {
            redirect('/auth/login');
        }

        if (empty($roles)) {
            return;
        }

        $currentRuleAuth = $_SESSION['user']['role'];
        if (!in_array($currentRuleAuth, $roles)) {
            Response::error("Forbidden", 403);
        }
    }
}
