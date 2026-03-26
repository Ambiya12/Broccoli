<?php

namespace App\Model;

use PDO;

class Session
{
    private $id;
    private $userId;
    private $token;
    private $createdAt;
    private $expiresAt;

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getId(): ?int       { return $this->id     ? (int) $this->id : null; }
    public function getUserId(): ?int   { return $this->userId ? (int) $this->userId : null; }
    public function getToken(): ?string    { return $this->token; }
    public function getCreatedAt(): ?string { return $this->createdAt; }
    public function getExpiresAt(): ?string { return $this->expiresAt; }

    public function create(int $userId, int $ttlSeconds = 86400): string
    {
        $token     = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', time() + $ttlSeconds);

        $query = $this->db->prepare(
            'INSERT INTO sessions (user_id, token, expires_at) VALUES (?, ?, ?)'
        );
        $query->execute([$userId, $token, $expiresAt]);

        return $token;
    }

    public function findByToken(string $token): ?self
    {
        $query = $this->db->prepare('SELECT * FROM sessions WHERE token = ?');
        $query->execute([$token]);
        $data = $query->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        if (strtotime($data['expires_at']) < time()) {
            return null;
        }

        $this->id        = $data['id'];
        $this->userId    = $data['user_id'];
        $this->token     = $data['token'];
        $this->createdAt = $data['created_at'];
        $this->expiresAt = $data['expires_at'];

        return $this;
    }

    public function delete(string $token): void
    {
        $query = $this->db->prepare('DELETE FROM sessions WHERE token = ?');
        $query->execute([$token]);
    }

    public function deleteByUserId(int $userId): void
    {
        $query = $this->db->prepare('DELETE FROM sessions WHERE user_id = ?');
        $query->execute([$userId]);
    }
}
