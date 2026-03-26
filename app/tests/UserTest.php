<?php

namespace App\tests;

use App\Model\User;
use PDO;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private PDO $pdo;
    private User $user;

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
        $this->user = new User($this->pdo);
    }

    public function testCreateReturnsId(): void
    {
        $id = $this->user->create('alice@example.com', 'secret', 'Alice');
        $this->assertIsInt($id);
        $this->assertGreaterThan(0, $id);
    }

    public function testCreateHashesPassword(): void
    {
        $this->user->create('hash@example.com', 'mypassword', 'Hash');
        $found = $this->user->findByEmail('hash@example.com');
        $this->assertNotNull($found);
        $this->assertNotEquals('mypassword', $found->getPassword());
        $this->assertTrue(password_verify('mypassword', $found->getPassword()));
    }

    public function testFindByEmailReturnsUserInstance(): void
    {
        $this->user->create('find@example.com', 'pass', 'Find');
        $found = $this->user->findByEmail('find@example.com');
        $this->assertInstanceOf(User::class, $found);
        $this->assertEquals('Find', $found->getUsername());
        $this->assertEquals('find@example.com', $found->getEmail());
    }

    public function testFindByEmailReturnsNullWhenNotFound(): void
    {
        $result = $this->user->findByEmail('nobody@example.com');
        $this->assertNull($result);
    }

    public function testFindByIdReturnsUserInstance(): void
    {
        $id    = $this->user->create('byid@example.com', 'pass', 'ById');
        $found = $this->user->findById($id);
        $this->assertInstanceOf(User::class, $found);
        $this->assertEquals('byid@example.com', $found->getEmail());
        $this->assertEquals($id, $found->getId());
        $this->assertNotNull($found->getCreatedAt());
    }

    public function testFindByIdReturnsNullWhenNotFound(): void
    {
        $result = $this->user->findById(9999);
        $this->assertNull($result);
    }

    public function testEmailExistsReturnsTrueForExistingEmail(): void
    {
        $this->user->create('exists@example.com', 'pass', 'Exists');
        $this->assertTrue($this->user->emailExists('exists@example.com'));
    }

    public function testEmailExistsReturnsFalseForUnknownEmail(): void
    {
        $this->assertFalse($this->user->emailExists('ghost@example.com'));
    }

    public function testAllReturnsAllUsers(): void
    {
        $this->user->create('a@example.com', 'pass', 'A');
        $this->user->create('b@example.com', 'pass', 'B');
        $all = $this->user->all();
        $this->assertCount(2, $all);
    }

    public function testAllReturnsEmptyArrayWhenNoUsers(): void
    {
        $all = $this->user->all();
        $this->assertIsArray($all);
        $this->assertEmpty($all);
    }
}
