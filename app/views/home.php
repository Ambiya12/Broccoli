<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Broccoli Arcade</title>
    <meta name="description" content="Un monde fun sur le brocoli: mini-defis, anecdotes et energie verte.">
    <link rel="stylesheet" href="/css/home.css">
</head>

<body class="home-page">
    <div class="page-bg" aria-hidden="true"></div>

    <header class="site-header">
        <a class="logo" href="/">Broccoli Arcade</a>
        <nav aria-label="Navigation principale">
            <ul class="nav-list">
                <li><a href="#features">Zones Fun</a></li>
                <li><a href="#facts">Brocco Facts</a></li>
                <li><a href="#challenge">Defi du Jour</a></li>
                <li><a href="#users">Green Crew</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="hero">
            <p class="hero-kicker">Cartoon Arcade Experience</p>
            <h1>Le royaume le plus cool du brocoli</h1>
            <p class="hero-text">
                Explore des infos sante, des faits improbables et des mini-defis.
                Une fois connecte, tu pourras enregistrer ton score et debloquer des missions.
            </p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="#challenge">Jouer Maintenant</a>
                <a class="btn btn-secondary" href="#facts">Explorer les Facts</a>
            </div>
            <p class="auth-hint">Connexion/inscription geree par l'equipe auth.</p>
        </section>

        <section id="features" class="section">
            <div class="section-head">
                <h2>Zones Fun</h2>
                <p>Trois espaces pour apprendre et s'amuser en mode green gamer.</p>
            </div>
            <div class="feature-grid">
                <?php foreach ($features as $feature): ?>
                    <article class="feature-card">
                        <h3><?= htmlspecialchars($feature['title']) ?></h3>
                        <p><?= htmlspecialchars($feature['description']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="facts" class="section">
            <div class="section-head">
                <h2>Brocco Facts</h2>
                <p>Des infos utiles et droles que tu peux sortir pendant les repas.</p>
            </div>
            <div class="facts-list">
                <?php foreach ($facts as $fact): ?>
                    <article class="fact-item">
                        <p><?= htmlspecialchars($fact) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="challenge" class="section challenge-panel">
            <div>
                <h2><?= htmlspecialchars($dailyChallenge['title']) ?></h2>
                <p><?= htmlspecialchars($dailyChallenge['description']) ?></p>
            </div>
            <div class="challenge-reward">
                <p>Recompense</p>
                <strong><?= htmlspecialchars($dailyChallenge['reward']) ?></strong>
            </div>
        </section>

        <section id="users" class="section">
            <div class="section-head">
                <h2>Green Crew</h2>
                <p>Les membres deja presents dans la team brocoli.</p>
            </div>
            <div class="users-container">
                <?php foreach ($users as $user): ?>
                    <article class="user-card">
                        <span class="user-id">#<?= htmlspecialchars($user['id']) ?></span>
                        <span class="user-name"><?= htmlspecialchars($user['name']) ?></span>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <p>Broccoli Arcade - Frontend pur PHP/CSS/JS sans framework.</p>
    </footer>
</body>

</html>