<?php

namespace App\tests;

use App\Model\Session;
use PDO;
use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{
    private PDO $pdo;
    private Session $session;

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
        $this->pdo->exec(
            "INSERT INTO users (email, password, username) VALUES ('test@test.com', 'hash', 'Tester')"
        );
        $this->session = new Session($this->pdo);
    }

    public function testCreateReturns64CharToken(): void
    {
        $token = $this->session->create(1);
        $this->assertIsString($token);
        $this->assertEquals(64, strlen($token));
    }

    public function testCreateTokensAreUnique(): void
    {
        $t1 = $this->session->create(1);
        $t2 = $this->session->create(1);
        $this->assertNotEquals($t1, $t2);
    }

    public function testFindByTokenReturnsSessionInstance(): void
    {
        $token   = $this->session->create(1);
        $session = $this->session->findByToken($token);
        $this->assertInstanceOf(Session::class, $session);
        $this->assertEquals(1, $session->getUserId());
        $this->assertEquals($token, $session->getToken());
        $this->assertNotNull($session->getId());
        $this->assertNotNull($session->getCreatedAt());
        $this->assertNotNull($session->getExpiresAt());
    }

    public function testFindByTokenReturnsNullForUnknownToken(): void
    {
        $result = $this->session->findByToken('doesnotexist');
        $this->assertNull($result);
    }

    public function testFindByTokenReturnsNullForExpiredSession(): void
    {
        $expiredAt = date('Y-m-d H:i:s', time() - 3600);
        $fakeToken = str_repeat('a', 64);
        $this->pdo->exec(
            "INSERT INTO sessions (user_id, token, expires_at)
             VALUES (1, '$fakeToken', '$expiredAt')"
        );
        $result = $this->session->findByToken($fakeToken);
        $this->assertNull($result);
    }

    public function testDeleteRemovesSession(): void
    {
        $token = $this->session->create(1);
        $this->session->delete($token);
        $this->assertNull($this->session->findByToken($token));
    }

    public function testDeleteByUserIdRemovesAllSessions(): void
    {
        $this->session->create(1);
        $this->session->create(1);
        $this->session->deleteByUserId(1);

        $stmt  = $this->pdo->query('SELECT COUNT(*) FROM sessions WHERE user_id = 1');
        $count = (int) $stmt->fetchColumn();
        $this->assertEquals(0, $count);
    }

    public function testDeleteByUserIdDoesNotAffectOtherUsers(): void
    {
        $this->pdo->exec(
            "INSERT INTO users (email, password, username) VALUES ('other@test.com', 'hash', 'Other')"
        );
        $this->session->create(1);
        $this->session->create(2);
        $this->session->deleteByUserId(1);

        $stmt  = $this->pdo->query('SELECT COUNT(*) FROM sessions WHERE user_id = 2');
        $count = (int) $stmt->fetchColumn();
        $this->assertEquals(1, $count);
    }
}
