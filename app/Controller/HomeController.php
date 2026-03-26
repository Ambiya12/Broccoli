<?php


namespace App\Controller;

use App\Model\User;

class HomeController {
    public function index() {
        $users = new User();
        $users = $users->all();
        require_once __DIR__ . '/../views/home.php';
    }
}
