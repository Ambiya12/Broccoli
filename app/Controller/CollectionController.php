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
        $images = array_filter($files, function($file) {
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            return in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        });

        // Générer le HTML pour afficher les images
        $html = '<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><title>Collection d\'images</title></head><body>';
        $html .= '<h1>Collection d\'images</h1>';
        if (empty($images)) {
            $html .= '<p>Aucune image trouvée.</p>';
        } else {
            $html .= '<div style="display: flex; flex-wrap: wrap;">';
            foreach ($images as $image) {
                $baseName = pathinfo($image['name'], PATHINFO_FILENAME);
                $extension = $image['extension'];
                $html .= '<div style="margin: 10px;">';
                $html .= '<img src="/uploads/' . htmlspecialchars($image['name']) . '" alt="' . htmlspecialchars($baseName) . '" style="max-width: 200px; max-height: 200px;">';
                $html .= '<p>' . htmlspecialchars($baseName) . ' (' . htmlspecialchars($extension) . ')</p>';
                $html .= '</div>';
            }
            $html .= '</div>';
        }
        $html .= '</body></html>';

        echo $html;
    }
}

?>