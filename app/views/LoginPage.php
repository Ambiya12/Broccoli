<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body class="login-page">
    <h2 class="login-banner">🥦🥦🥦 Bienvenue chez les Broccolis 🥦🥦🥦</h2>

    <main class="login-wrapper">
        <img src="/assets/broccoli-image.png" alt="Broccoli" style="width: 200px; margin-bottom: 40px;">
        <section class="login-card">
            <h1 class="title">Connexion</h1>
            <form class="login-form" method="post" action="#">
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email" placeholder="broccoli@exemple.com" required>

                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="********" required>

                <button type="submit">Se connecter</button>
            </form>

            <a class="back-link" href="/signup">Pas de compte ? S'inscrire</a>
        </section>
        <img src="/assets/broccoli-image.png" alt="Broccoli" style="width: 200px; margin-bottom: 40px;">
    </main>
</body>

</html>
