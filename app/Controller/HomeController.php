<?php


namespace App\Controller;

use App\core\Database;
use App\Model\User;

class HomeController {
    public function index() {
        $userModel = new User(Database::getConnection());
        $users = $userModel->all();

        $features = [
            [
                'title' => 'Brocco Quest',
                'description' => 'Complete mini missions and earn leaf points.',
            ],
            [
                'title' => 'Fact Spinner',
                'description' => 'Discover fun facts about broccoli with one click.',
            ],
            [
                'title' => 'Green Crew',
                'description' => 'Build your vegetable team and climb the leaderboard.',
            ],
        ];

        $facts = [
            'Broccoli belongs to the cruciferous family, just like cauliflower.',
            'Broccoli is packed with Vitamin C, fiber, and powerful antioxidants.',
            'Its name comes from the Italian "broccolo", meaning young shoot.',
        ];

        $dailyChallenge = [
            'title' => 'Daily Challenge: Green Combo',
            'description' => 'Find 3 health benefits of broccoli in less than 20 seconds.',
            'reward' => '+150 leaf points',
        ];

        require_once __DIR__ . '/../views/home.php';
    }

    public function login() {
        require_once __DIR__ . '/../views/LoginPage.php';
    }

    public function signup() {
        require_once __DIR__ . '/../views/Signup.php';
    }
}
