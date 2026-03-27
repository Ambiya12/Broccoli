<?php

namespace App\Model;

use PDO;

class File {
    private $fileId;
    private $name;
    private $extension;
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
        $query = $this->db->query('SELECT fileId, name, extension, size, created_at FROM files');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupérer un fichier par ID
     */
    public function findById($fileId): ?self {
        $query = $this->db->prepare('SELECT * FROM files WHERE fileId = ?');
        $query->execute([$fileId]);
        $data = $query->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        $this->fileId    = $data['fileId'];
        $this->name      = $data['name'];
        $this->extension = $data['extension'];
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
        $this->extension = $data['extension'];
        $this->size      = $data['size'];
        $this->createdAt = $data['created_at'];

        return $this;
    }

    public function fileExists(string $name): bool
    {
        $query = $this->db->prepare('SELECT fileId FROM files WHERE name = ?');
        $query->execute([$name]);
        return $query->fetch() !== false;
    }

    public function create(string $name, int $size): int
    {
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $query = $this->db->prepare(
            'INSERT INTO files (name, extension, size) VALUES (?, ?, ?)'
        );
        $query->execute([$name, $extension, $size]);
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
     * Get the value of extension
     */ 
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Get the base name (without extension)
     */ 
    public function getBaseName()
    {
        return pathinfo($this->name, PATHINFO_FILENAME);
    }
}

?>