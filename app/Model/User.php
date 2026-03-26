<?php

namespace App\Model;

class User {
    public function all(): array {
        $users = json_decode(file_get_contents(__DIR__ . '/../database/db.json'), true)['user'];
        return $users;
    }
}
