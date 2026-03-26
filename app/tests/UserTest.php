<?php

namespace App\tests;

use App\Model\User;
use PDO;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private PDO $pdo;
    private User $user;

    private const VALID_PASSWORD = 'motdepasse123';

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
        $this->user = new User($this->pdo);
    }

    public function testCreateReturnsId(): void
    {
        $id = $this->user->create('alice@example.com', self::VALID_PASSWORD, 'Alice');
        $this->assertIsInt($id);
        $this->assertGreaterThan(0, $id);
    }

    public function testCreateThrowsForPasswordUnder12Chars(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->user->create('short@example.com', 'court', 'Short');
    }

    public function testDefaultRoleIsUser(): void
    {
        $id   = $this->user->create('user@example.com', self::VALID_PASSWORD, 'User');
        $found = $this->user->findById($id);
        $this->assertEquals('user', $found->getRole());
        $this->assertFalse($found->isAdmin());
    }

    public function testCreateWithAdminRole(): void
    {
        $id    = $this->user->create('admin@example.com', self::VALID_PASSWORD, 'Admin', 'admin');
        $found = $this->user->findById($id);
        $this->assertEquals('admin', $found->getRole());
        $this->assertTrue($found->isAdmin());
    }

    public function testPasswordIsNeverStoredInPlainText(): void
    {
        $this->user->create('hash@example.com', self::VALID_PASSWORD, 'Hash');

        $stmt   = $this->pdo->query("SELECT password FROM users WHERE email = 'hash@example.com'");
        $stored = $stmt->fetchColumn();

        $this->assertNotEquals(self::VALID_PASSWORD, $stored);
        $this->assertStringStartsWith('$2y$', $stored);
    }

    public function testVerifyPasswordReturnsFalseOnFreshInstanceWithNoHashLoaded(): void
    {
        $fresh = new User($this->pdo);
        $this->assertFalse($fresh->verifyPassword(self::VALID_PASSWORD));
    }

    public function testVerifyPasswordReturnsTrueForCorrectPassword(): void
    {
        $this->user->create('verify@example.com', self::VALID_PASSWORD, 'Verify');
        $found = $this->user->findByEmail('verify@example.com');
        $this->assertTrue($found->verifyPassword(self::VALID_PASSWORD));
    }

    public function testVerifyPasswordReturnsFalseForWrongPassword(): void
    {
        $this->user->create('wrong@example.com', self::VALID_PASSWORD, 'Wrong');
        $found = $this->user->findByEmail('wrong@example.com');
        $this->assertFalse($found->verifyPassword('mauvaismdp999'));
    }

    public function testVerifyPasswordReturnsFalseWithoutPepper(): void
    {
        $this->user->create('pepper@example.com', self::VALID_PASSWORD, 'Pepper');
        $stmt = $this->pdo->query("SELECT password FROM users WHERE email = 'pepper@example.com'");
        $hash = $stmt->fetchColumn();
        $this->assertFalse(password_verify(self::VALID_PASSWORD, $hash));
    }

    public function testFindByEmailReturnsUserInstance(): void
    {
        $this->user->create('find@example.com', self::VALID_PASSWORD, 'Find');
        $found = $this->user->findByEmail('find@example.com');
        $this->assertInstanceOf(User::class, $found);
        $this->assertEquals('Find', $found->getUsername());
        $this->assertEquals('find@example.com', $found->getEmail());
    }

    public function testFindByEmailReturnsNullWhenNotFound(): void
    {
        $this->assertNull($this->user->findByEmail('nobody@example.com'));
    }

    public function testFindByIdReturnsUserInstance(): void
    {
        $id    = $this->user->create('byid@example.com', self::VALID_PASSWORD, 'ById');
        $found = $this->user->findById($id);
        $this->assertInstanceOf(User::class, $found);
        $this->assertEquals('byid@example.com', $found->getEmail());
        $this->assertEquals($id, $found->getId());
        $this->assertNotNull($found->getCreatedAt());
    }

    public function testFindByIdReturnsNullWhenNotFound(): void
    {
        $this->assertNull($this->user->findById(9999));
    }

    public function testEmailExistsReturnsTrueForExistingEmail(): void
    {
        $this->user->create('exists@example.com', self::VALID_PASSWORD, 'Exists');
        $this->assertTrue($this->user->emailExists('exists@example.com'));
    }

    public function testEmailExistsReturnsFalseForUnknownEmail(): void
    {
        $this->assertFalse($this->user->emailExists('ghost@example.com'));
    }

    public function testAllReturnsAllUsers(): void
    {
        $this->user->create('a@example.com', self::VALID_PASSWORD, 'A');
        $this->user->create('b@example.com', self::VALID_PASSWORD, 'B');
        $this->assertCount(2, $this->user->all());
    }

    public function testAllReturnsEmptyArrayWhenNoUsers(): void
    {
        $all = $this->user->all();
        $this->assertIsArray($all);
        $this->assertEmpty($all);
    }
}
