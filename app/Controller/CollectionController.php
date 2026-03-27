<?php

namespace App\Controller;

use App\core\Database;
use App\Model\File;

class CollectionController {
    private $fileModel;

    public function __construct()
    {
        $db = Database::getConnection();
        $this->fileModel = new File($db);
    }

    public function index()
    {
        $files = $this->fileModel->all();
        $images = array_values(array_filter($files, function($file) {
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            return in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        }));

        require_once __DIR__ . '/../views/collection.php';
    }
}

?>