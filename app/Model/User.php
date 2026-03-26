<?php

namespace App\Model;

use PDO;

class User
{
    private $id;
    private $email;
    private $password;
    private $username;
    private $createdAt;

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getId(): ?int      { return $this->id       ? (int) $this->id : null; }
    public function getEmail(): ?string    { return $this->email; }
    public function getPassword(): ?string { return $this->password; }
    public function getUsername(): ?string { return $this->username; }
    public function getCreatedAt(): ?string { return $this->createdAt; }

    public function all(): array
    {
        $query = $this->db->query('SELECT id, email, username, created_at FROM users');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByEmail(string $email): ?self
    {
        $query = $this->db->prepare('SELECT * FROM users WHERE email = ?');
        $query->execute([$email]);
        $data = $query->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        $this->id        = $data['id'];
        $this->email     = $data['email'];
        $this->password  = $data['password'];
        $this->username  = $data['username'];
        $this->createdAt = $data['created_at'];

        return $this;
    }

    public function findById(int $id): ?self
    {
        $query = $this->db->prepare('SELECT * FROM users WHERE id = ?');
        $query->execute([$id]);
        $data = $query->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        $this->id        = $data['id'];
        $this->email     = $data['email'];
        $this->password  = $data['password'];
        $this->username  = $data['username'];
        $this->createdAt = $data['created_at'];

        return $this;
    }

    public function emailExists(string $email): bool
    {
        $query = $this->db->prepare('SELECT id FROM users WHERE email = ?');
        $query->execute([$email]);
        return $query->fetch() !== false;
    }

    public function create(string $email, string $password, string $username): int
    {
        $hash  = password_hash($password, PASSWORD_BCRYPT);
        $query = $this->db->prepare(
            'INSERT INTO users (email, password, username) VALUES (?, ?, ?)'
        );
        $query->execute([$email, $hash, $username]);
        return (int) $this->db->lastInsertId();
    }
}
