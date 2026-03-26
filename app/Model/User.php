<?php

namespace App\Model;

use PDO;

class User
{
    private $id;
    private $email;
    private $username;
    private $role;
    private $createdAt;

    // Le hash du mot de passe reste strictement privé : aucun getter exposé.
    private $passwordHash;

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getId(): ?int        { return $this->id    ? (int) $this->id : null; }
    public function getEmail(): ?string    { return $this->email; }
    public function getUsername(): ?string { return $this->username; }
    public function getRole(): ?string     { return $this->role; }
    public function getCreatedAt(): ?string { return $this->createdAt; }

    // Applique le poivre avant tout hash ou vérification.
    // Recette : mot de passe + "brocoli" encodé en base64 (YnJvY29saQ==).
    private function pepper(string $password): string
    {
        return $password . base64_encode('brocoli');
    }

    // Vérifie le mot de passe en clair contre le hash stocké.
    // Le plain text ne sort jamais de cette méthode : retourne uniquement un bool.
    public function verifyPassword(string $plainPassword): bool
    {
        if ($this->passwordHash === null) {
            return false;
        }
        return password_verify($this->pepper($plainPassword), $this->passwordHash);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function all(): array
    {
        $query = $this->db->query('SELECT id, email, username, role, created_at FROM users');
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

        $this->hydrate($data);
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

        $this->hydrate($data);
        return $this;
    }

    public function emailExists(string $email): bool
    {
        $query = $this->db->prepare('SELECT id FROM users WHERE email = ?');
        $query->execute([$email]);
        return $query->fetch() !== false;
    }

    public function create(string $email, string $password, string $username, string $role = 'user'): int
    {
        if (strlen($password) < 12) {
            throw new \InvalidArgumentException('Le mot de passe doit contenir au moins 12 caractères.');
        }

        $hash  = password_hash($this->pepper($password), PASSWORD_BCRYPT);
        $query = $this->db->prepare(
            'INSERT INTO users (email, password, username, role) VALUES (?, ?, ?, ?)'
        );
        $query->execute([$email, $hash, $username, $role]);
        return (int) $this->db->lastInsertId();
    }

    private function hydrate(array $data): void
    {
        $this->id           = $data['id'];
        $this->email        = $data['email'];
        $this->passwordHash = $data['password'];
        $this->username     = $data['username'];
        $this->role         = $data['role'];
        $this->createdAt    = $data['created_at'];
    }
}
