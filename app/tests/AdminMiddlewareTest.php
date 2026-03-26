<?php

namespace App\tests;

use App\core\Database;
use App\core\Middleware\AdminMiddleware;
use App\Model\Session;
use PDO;
use PHPUnit\Framework\TestCase;

class AdminMiddlewareTest extends TestCase
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

    public function testIsAdminReturnsFalseWithNoCookie(): void
    {
        unset($_COOKIE['session_token']);
        $mw = new AdminMiddleware();
        $this->assertFalse($mw->isAdmin());
    }

    public function testIsAdminReturnsFalseForInvalidToken(): void
    {
        $_COOKIE['session_token'] = 'badtoken';
        $mw = new AdminMiddleware();
        $this->assertFalse($mw->isAdmin());
    }

    public function testIsAdminReturnsFalseForUserRole(): void
    {
        $this->pdo->exec(
            "INSERT INTO users (email, password, username, role) VALUES ('user@test.com', 'h', 'User', 'user')"
        );
        $token = (new Session($this->pdo))->create(1);

        $_COOKIE['session_token'] = $token;
        $mw = new AdminMiddleware();
        $this->assertFalse($mw->isAdmin());
    }

    public function testIsAdminReturnsTrueForAdminRole(): void
    {
        $this->pdo->exec(
            "INSERT INTO users (email, password, username, role) VALUES ('admin@test.com', 'h', 'Admin', 'admin')"
        );
        $token = (new Session($this->pdo))->create(1);

        $_COOKIE['session_token'] = $token;
        $mw = new AdminMiddleware();
        $this->assertTrue($mw->isAdmin());
    }

    public function testIsAdminReturnsFalseForExpiredSession(): void
    {
        $expired = date('Y-m-d H:i:s', time() - 3600);
        $token   = str_repeat('x', 64);
        $this->pdo->exec(
            "INSERT INTO users (email, password, username, role) VALUES ('a@test.com', 'h', 'A', 'admin')"
        );
        $this->pdo->exec(
            "INSERT INTO sessions (user_id, token, expires_at) VALUES (1, '$token', '$expired')"
        );

        $_COOKIE['session_token'] = $token;
        $mw = new AdminMiddleware();
        $this->assertFalse($mw->isAdmin());
    }
}
