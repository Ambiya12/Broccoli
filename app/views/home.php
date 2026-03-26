<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue</title>
    <link rel="stylesheet" href="/css/home.css">
</head>

<body class="home-page">

    <header class="hero">
        <h1>Bienvenue sur Mon Projet MVC</h1>
        <p>Testez et crée vos projets en toute simplicité</p>
    </header>

    <section id="users" class="users-section">
        <h2>Utilisateurs</h2>
        <div class="users-container">
            <?php foreach ($users as $user): ?>
                <div class="user-card">
                    <span class="user-id"><?= htmlspecialchars($user['id']) ?></span>
                    <span class="user-name"><?= htmlspecialchars($user['name']) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

</body>

</html>