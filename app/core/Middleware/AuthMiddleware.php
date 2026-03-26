<?php

namespace App\core\Middleware;

use App\core\Database;
use App\Model\Session;

class AuthMiddleware implements MiddlewareInterface
{
    /** @codeCoverageIgnore */
    public function handle(): void
    {
        if (!$this->isAuthenticated()) {
            header('Location: /login');
            exit;
        }
    }

    // Séparé de handle() pour être testable sans header()/exit.
    public function isAuthenticated(): bool
    {
        $token = $_COOKIE['session_token'] ?? null;

        if (!$token) {
            return false;
        }

        $session = new Session(Database::getConnection());
        return $session->findByToken($token) !== null;
    }
}
