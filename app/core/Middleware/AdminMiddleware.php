<?php

namespace App\core\Middleware;

use App\core\Database;
use App\Model\Session;
use App\Model\User;

class AdminMiddleware implements MiddlewareInterface
{
    /** @codeCoverageIgnore */
    public function handle(): void
    {
        if (!$this->isAdmin()) {
            http_response_code(403);
            echo '403 - Accès refusé.';
            exit;
        }
    }

    // Séparé de handle() pour être testable sans http_response_code()/exit.
    public function isAdmin(): bool
    {
        $token = $_COOKIE['session_token'] ?? null;

        if (!$token) {
            return false;
        }

        $db      = Database::getConnection();
        $session = (new Session($db))->findByToken($token);

        if (!$session) {
            return false;
        }

        $user = (new User($db))->findById($session->getUserId());

        return $user !== null && $user->isAdmin();
    }
}
