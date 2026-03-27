<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body class="login-page">
<h2 class="login-banner">🥦🥦🥦 Bienvenue chez les Broccolis 🥦🥦🥦</h2>
    <main class="login-wrapper">
        <img src="/assets/broccoli-image.png" alt="Broccoli" style="width: 200px; margin-bottom: 40px;">
        <section class="login-card">
            <h1 class="title">Inscription</h1>

            <?php if (!empty($error)): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <form class="login-form" method="post" action="/register">
                <label for="username">Nom complet</label>
                <input type="text" id="username" name="username" placeholder="Brocoli CHAUD" required>

                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email" placeholder="broccoli@exemple.com" required>

                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="********" required>

                <label for="confirm_password">Confirmer le mot de passe</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="********" required>

                <button type="submit">S'inscrire</button>
            </form>

            <a class="back-link" href="/login">Déjà un compte ? Se connecter</a>
        </section>
        <img src="/assets/broccoli-image.png" alt="Broccoli" style="width: 200px; margin-bottom: 40px;">
    </main>
</body>

</html>

