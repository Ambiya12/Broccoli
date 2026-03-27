<?php

namespace App\Controller;

use App\core\Database;
use App\Model\File;

class FileController {
    private $fileModel;

    public function __construct()
    {
        $db = Database::getConnection();
        $this->fileModel = new File($db);
    }

    public function upload()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
            $file = $_FILES['file'];

            if ($file['error'] !== UPLOAD_ERR_OK) {
                http_response_code(400);
                echo json_encode(['error' => 'Erreur lors de l\'upload du fichier.']);
                return;
            }

            $name = basename($file['name']);
            $size = $file['size'];

            if ($this->fileModel->fileExists($name)) {
                http_response_code(409);
                echo json_encode(['error' => 'Un fichier avec ce nom existe déjà.']);
                return;
            }

            $uploadDir = __DIR__ . '/../../public/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $path = $uploadDir . $name;
            if (move_uploaded_file($file['tmp_name'], $path)) {
                $id = $this->fileModel->create($name, $size);
                http_response_code(201);
                echo json_encode(['success' => 'Fichier uploadé avec succès.', 'id' => $id]);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Erreur lors du déplacement du fichier.']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Requête invalide.']);
        }
    }

    public function download()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID du fichier manquant.']);
            return;
        }

        $file = $this->fileModel->findById($id);
        if (!$file) {
            http_response_code(404);
            echo json_encode(['error' => 'Fichier non trouvé.']);
            return;
        }

        $path = __DIR__ . '/../../public/uploads/' . $file->getName();
        if (file_exists($path)) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $file->getName() . '"');
            header('Content-Length: ' . filesize($path));
            readfile($path);
            exit;
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Fichier non trouvé sur le serveur.']);
        }
    }
}

?>