<?php


namespace App\Controller;

use App\Model\User;

class HomeController {
    public function index() {
        $userModel = new User();
        $users = $userModel->all();

        $features = [
            [
                'title' => 'Brocco Quest',
                'description' => 'Accomplis des mini missions et gagne des points feuilles.',
            ],
            [
                'title' => 'Fact Spinner',
                'description' => 'Decouvre des anecdotes rigolotes sur le brocoli en un clic.',
            ],
            [
                'title' => 'Green Crew',
                'description' => 'Forme ton equipe legume et grimpe au classement.',
            ],
        ];

        $facts = [
            'Le brocoli appartient a la famille des cruciferes, comme le chou-fleur.',
            'Le brocoli contient de la vitamine C, des fibres et des antioxydants.',
            'Son nom vient de l\'italien "broccolo", qui signifie jeune pousse.',
        ];

        $dailyChallenge = [
            'title' => 'Defi du jour: Green Combo',
            'description' => 'Trouve 3 bienfaits sante du brocoli en moins de 20 secondes.',
            'reward' => '+150 leaf points',
        ];

        require_once __DIR__ . '/../views/home.php';
    }
}
