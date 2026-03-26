<?php


namespace App\Controller;

use App\core\Database;
use App\Model\User;

class HomeController {
    public function index() {
        $users = new User(Database::getConnection());
        $users = $users->all();
        require_once __DIR__ . '/../views/home.php';
    }
}
