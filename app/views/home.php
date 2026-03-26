<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Broccoli Arcade</title>
    <meta name="description" content="A fun world of broccoli: mini challenges, facts, and green energy.">
    <link rel="stylesheet" href="/css/home.css">
</head>

<body class="home-page">
    <div class="page-bg" aria-hidden="true"></div>

    <header class="site-header">
        <a class="logo" href="/">Broccoli Arcade</a>
        <nav aria-label="Main Navigation">
            <ul class="nav-list">
                <li><a href="#features">Fun Zones</a></li>
                <li><a href="#facts">Broccoli Facts</a></li>
                <li><a href="#challenge">Daily Challenge</a></li>
                <li><a href="#users">Green Crew</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="hero">
            <p class="hero-kicker">Cartoon Arcade Experience</p>
            <h1>The coolest broccoli kingdom</h1>
            <p class="hero-text">
                Explore health info, amazing facts, and mini challenges.
                Once logged in, you can save your score and unlock special missions.
            </p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="#challenge">Play Now</a>
                <a class="btn btn-secondary" href="#facts">Explore Facts</a>
            </div>
            <p class="auth-hint">Login/signup managed by the auth team.</p>
        </section>

        <section id="features" class="section">
            <div class="section-head">
                <h2>Fun Zones</h2>
                <p>Three spaces to learn and have fun in green gamer mode.</p>
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
                <h2>Broccoli Facts</h2>
                <p>Useful and fun info you can share at dinner time.</p>
            </div>
            <button type="button" class="btn btn-fact" id="fact-spinner">Fact Spinner</button>
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
                <p>Reward</p>
                <strong><?= htmlspecialchars($dailyChallenge['reward']) ?></strong>
                <button type="button" class="btn btn-refresh" id="challenge-reroll">New Challenge</button>
            </div>
        </section>

        <section id="users" class="section">
            <div class="section-head">
                <h2>Green Crew</h2>
                <p>Members already part of the broccoli team.</p>
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
        <p>Broccoli Arcade - Pure frontend PHP/CSS/JS without framework.</p>
    </footer>

    <script src="/js/home.js"></script>
</body>

</html>