<?php

namespace App\tests;

use App\core\Database;
use App\core\Middleware\AuthMiddleware;
use App\Model\Session;
use App\Model\User;
use PDO;
use PHPUnit\Framework\TestCase;

class AuthMiddlewareTest extends TestCase
{
    private PDO $pdo;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec('
            CREATE TABLE users (
                id         INTEGER PRIMARY KEY AUTOINCREMENT,
                email      VARCHAR(255) NOT NULL UNIQUE,
                password   VARCHAR(255) NOT NULL,
                username   VARCHAR(100) NOT NULL,
                role       VARCHAR(20)  NOT NULL DEFAULT "user",
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ');
        $this->pdo->exec('
            CREATE TABLE sessions (
                id         INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id    INTEGER NOT NULL,
                token      VARCHAR(64) NOT NULL UNIQUE,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                expires_at DATETIME NOT NULL
            )
        ');
        Database::setConnection($this->pdo);
    }

    protected function tearDown(): void
    {
        unset($_COOKIE['session_token']);
        Database::reset();
    }

    public function testIsAuthenticatedReturnsFalseWithNoCookie(): void
    {
        unset($_COOKIE['session_token']);
        $mw = new AuthMiddleware();
        $this->assertFalse($mw->isAuthenticated());
    }

    public function testIsAuthenticatedReturnsFalseForInvalidToken(): void
    {
        $_COOKIE['session_token'] = 'invalidtoken';
        $mw = new AuthMiddleware();
        $this->assertFalse($mw->isAuthenticated());
    }

    public function testIsAuthenticatedReturnsTrueForValidSession(): void
    {
        $this->pdo->exec(
            "INSERT INTO users (email, password, username) VALUES ('u@test.com', 'h', 'U')"
        );
        $session = new Session($this->pdo);
        $token   = $session->create(1);

        $_COOKIE['session_token'] = $token;
        $mw = new AuthMiddleware();
        $this->assertTrue($mw->isAuthenticated());
    }

    public function testIsAuthenticatedReturnsFalseForExpiredSession(): void
    {
        $expired = date('Y-m-d H:i:s', time() - 3600);
        $token   = str_repeat('e', 64);
        $this->pdo->exec(
            "INSERT INTO users (email, password, username) VALUES ('exp@test.com', 'h', 'Exp')"
        );
        $this->pdo->exec(
            "INSERT INTO sessions (user_id, token, expires_at) VALUES (1, '$token', '$expired')"
        );

        $_COOKIE['session_token'] = $token;
        $mw = new AuthMiddleware();
        $this->assertFalse($mw->isAuthenticated());
    }
}
