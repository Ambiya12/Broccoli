<?php

namespace App\Model;

use PDO;

class File {
    private $fileId;
    private $name;
    private $size;
    private $createdAt;

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Récupérer tous les fichiers
     */
    public function all(): array {
        $query = $this->db->query('SELECT id, name, size, created_at FROM files');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupérer un fichier par ID
     */
    public function findById($fileId): ?array {
        $query = $this->db->prepare('SELECT * FROM files WHERE fileId = ?');
        $query->execute([$fileId]);
        $data = $query->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        $this->fileId    = $data['fileId'];
        $this->name      = $data['name'];
        $this->size      = $data['size'];
        $this->createdAt = $data['created_at'];

        return $this;
    }

    /**
     * Récupérer un fichier par son nom
     */
    public function findByName(string $name): ?self
    {
        $query = $this->db->prepare('SELECT * FROM files WHERE name = ?');
        $query->execute([$name]);
        $data = $query->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        $this->fileId    = $data['fileId'];
        $this->name      = $data['name'];
        $this->size      = $data['size'];
        $this->createdAt = $data['created_at'];

        return $this;
    }

    public function fileExists(string $name): bool
    {
        $query = $this->db->prepare('SELECT id FROM files WHERE name = ?');
        $query->execute([$name]);
        return $query->fetch() !== false;
    }

    public function create(string $name, int $size): int
    {
        $query = $this->db->prepare(
            'INSERT INTO files (name, size) VALUES (?, ?)'
        );
        $query->execute([$name, $size]);
        return (int) $this->db->lastInsertId();
    }

    /**
     * Get the value of fileId
     */ 
    public function getFileId()
    {
        return $this->fileId;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of size
     */ 
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set the value of size
     *
     * @return  self
     */ 
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }
}

?>