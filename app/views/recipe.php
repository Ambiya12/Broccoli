<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe — Broccoli</title>
    <link rel="stylesheet" href="/css/home.css">
    <style>
        .site-wrapper {
            overflow-y: auto;
            justify-content: flex-start;
            height: calc(100vh - 40px);
        }

        .recipe-main {
            z-index: 10;
            position: relative;
            flex: 1;
            padding: 40px 0 60px;
        }

        .recipe-header {
            margin-bottom: 60px;
        }

        .recipe-title {
            font-size: 2.2rem;
            font-weight: 900;
            letter-spacing: -0.03em;
            margin: 0 0 8px 0;
            text-transform: lowercase;
        }

        .recipe-subtitle {
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            opacity: 0.4;
            margin: 0;
        }

        /* Étapes */
        .recipe-steps {
            display: flex;
            flex-direction: column;
            gap: 32px;
        }

        .step-card {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            border: 1px solid rgba(0,0,0,0.15);
            border-radius: 20px;
            overflow: hidden;
            background: rgba(255,255,255,0.35);
            backdrop-filter: blur(10px);
            transition: border-color 0.25s, box-shadow 0.25s;
        }

        .step-card:hover {
            border-color: #111;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        }

        .step-card.reverse {
            direction: rtl;
        }

        .step-card.reverse > * {
            direction: ltr;
        }

        .step-image-wrap {
            position: relative;
            overflow: hidden;
            min-height: 280px;
            background: #e8e8e8;
        }

        .step-image-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.4s ease;
        }

        .step-card:hover .step-image-wrap img {
            transform: scale(1.03);
        }

        .step-number-overlay {
            position: absolute;
            top: 16px;
            left: 20px;
            font-size: 5rem;
            font-weight: 900;
            line-height: 1;
            letter-spacing: -0.04em;
            color: white;
            text-shadow: 0 2px 12px rgba(0,0,0,0.3);
            pointer-events: none;
            z-index: 2;
            background: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' fill='%23fff'/%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.15'/%3E%3C/svg%3E");
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .step-content {
            padding: 36px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 14px;
        }

        .step-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            opacity: 0.4;
        }

        .step-tag-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #111;
            opacity: 0.6;
        }

        .step-name {
            font-size: 1.6rem;
            font-weight: 900;
            letter-spacing: -0.03em;
            line-height: 1.1;
            margin: 0;
        }

        .step-joke {
            font-size: 0.8rem;
            font-weight: 700;
            font-style: italic;
            opacity: 0.5;
            margin: 0;
            line-height: 1.4;
            letter-spacing: 0.02em;
        }

        .step-desc {
            font-size: 0.75rem;
            font-weight: 600;
            line-height: 1.6;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            opacity: 0.7;
            margin: 0;
            font-family: "Trebuchet MS", sans-serif;
        }

        .step-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 6px;
        }

        .step-badge-pill {
            display: inline-block;
            padding: 4px 12px;
            border: 1px solid rgba(0,0,0,0.2);
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: lowercase;
        }

        /* Image fallback */
        .step-image-wrap.no-img {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 5rem;
        }

        /* Responsive */
        @media (max-width: 700px) {
            .step-card,
            .step-card.reverse {
                grid-template-columns: 1fr;
                direction: ltr;
            }
            .step-image-wrap {
                min-height: 200px;
            }
            .step-content {
                padding: 24px 24px;
            }
            .step-name {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
    <div class="site-wrapper">
        <header class="top-nav">
            <div class="logo">
                <div class="logo-text">
                    Broc<br>coli
                </div>
                <div class="logo-stars">
                    **<br>*
                </div>
            </div>
            <nav class="main-nav">
                <a href="/">main</a>
                <a href="/recipe" class="active">recipe</a>
                <a href="#">fun fact</a>
                <a href="/collection">collection</a>
            </nav>
            <div class="main-nav">
                <?php if ($isLoggedIn): ?>
                    <a href="/logout">logout</a>
                <?php else: ?>
                    <a href="/login">login</a>
                <?php endif; ?>
            </div>
        </header>

        <main class="recipe-main">
            <div class="recipe-header">
                <h1 class="recipe-title">how to grow your broccoli</h1>
                <p class="recipe-subtitle">a serious guide for serious vegetable people</p>
            </div>

            <div class="recipe-steps">

                <!-- Étape 1 -->
                <div class="step-card">
                    <div class="step-image-wrap">
                        <span class="step-number-overlay">01</span>
                        <img
                            src="https://images.unsplash.com/photo-1622383563227-04401ab4e5ea?w=700&q=80"
                            alt="Graines de brocoli"
                            onerror="this.style.display='none'; this.parentNode.classList.add('no-img'); this.parentNode.innerHTML='<span class=\'step-number-overlay\'>01</span>🌱';"
                        >
                    </div>
                    <div class="step-content">
                        <span class="step-tag"><span class="step-tag-dot"></span>étape 01</span>
                        <h2 class="step-name">choisir ses graines</h2>
                        <p class="step-joke">"Parce que tous les brocolis ne se valent pas — mais ils sont tous meilleurs que les épinards."</p>
                        <p class="step-desc">
                            Optez pour une variété adaptée à votre climat. Calabrese
                            pour la saveur, Romanesco pour impressionner vos invités,
                            ou Purple Sprouting pour les rebelles du potager.
                        </p>
                        <div class="step-badge">
                            <span class="step-badge-pill">variétés recommandées</span>
                            <span class="step-badge-pill">pH 6–7</span>
                        </div>
                    </div>
                </div>

                <!-- Étape 2 -->
                <div class="step-card reverse">
                    <div class="step-image-wrap">
                        <span class="step-number-overlay">02</span>
                        <img
                            src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=700&q=80"
                            alt="Préparer le sol"
                            onerror="this.style.display='none'; this.parentNode.classList.add('no-img'); this.parentNode.innerHTML='<span class=\'step-number-overlay\'>02</span>🪱';"
                        >
                    </div>
                    <div class="step-content">
                        <span class="step-tag"><span class="step-tag-dot"></span>étape 02</span>
                        <h2 class="step-name">préparer le sol</h2>
                        <p class="step-joke">"Votre brocoli est aussi exigeant sur la terre que vous l'êtes sur le canapé."</p>
                        <p class="step-desc">
                            Ameublissez le sol sur 30 cm de profondeur. Incorporez
                            du compost bien mûr. Un sol riche, bien drainé, légèrement
                            alcalin est le rêve absolu de votre futur brocoli.
                        </p>
                        <div class="step-badge">
                            <span class="step-badge-pill">compost recommandé</span>
                            <span class="step-badge-pill">30 cm de profondeur</span>
                        </div>
                    </div>
                </div>

                <!-- Étape 3 -->
                <div class="step-card">
                    <div class="step-image-wrap">
                        <span class="step-number-overlay">03</span>
                        <img
                            src="https://images.unsplash.com/photo-1592982537447-7440770cbfc9?w=700&q=80"
                            alt="Semer les graines"
                            onerror="this.style.display='none'; this.parentNode.classList.add('no-img'); this.parentNode.innerHTML='<span class=\'step-number-overlay\'>03</span>🫘';"
                        >
                    </div>
                    <div class="step-content">
                        <span class="step-tag"><span class="step-tag-dot"></span>étape 03</span>
                        <h2 class="step-name">semer les graines</h2>
                        <p class="step-joke">"Le moment le plus angoissant de votre existence de jardinier amateur."</p>
                        <p class="step-desc">
                            Semez en godets intérieurs 4 à 6 semaines avant le repiquage.
                            Profondeur : 1 cm. Gardez le sol humide à 18–21°C.
                            La germination prend 5 à 10 jours — soyez patient.
                        </p>
                        <div class="step-badge">
                            <span class="step-badge-pill">1 cm de profondeur</span>
                            <span class="step-badge-pill">18–21 °C</span>
                        </div>
                    </div>
                </div>

                <!-- Étape 4 -->
                <div class="step-card reverse">
                    <div class="step-image-wrap">
                        <span class="step-number-overlay">04</span>
                        <img
                            src="https://images.unsplash.com/photo-1520412099551-62b6bafeb5bb?w=700&q=80"
                            alt="Arroser les plants"
                            onerror="this.style.display='none'; this.parentNode.classList.add('no-img'); this.parentNode.innerHTML='<span class=\'step-number-overlay\'>04</span>💧';"
                        >
                    </div>
                    <div class="step-content">
                        <span class="step-tag"><span class="step-tag-dot"></span>étape 04</span>
                        <h2 class="step-name">arroser avec constance</h2>
                        <p class="step-joke">"Ni trop, ni trop peu — exactement comme répondre aux textos."</p>
                        <p class="step-desc">
                            2 à 3 cm d'eau par semaine, de façon régulière. Un
                            arrosage irrégulier provoque des têtes creuses et du stress
                            hydrique. Un brocoli stressé ne vous pardonnera pas.
                        </p>
                        <div class="step-badge">
                            <span class="step-badge-pill">2–3 cm / semaine</span>
                            <span class="step-badge-pill">arrosage au pied</span>
                        </div>
                    </div>
                </div>

                <!-- Étape 5 -->
                <div class="step-card">
                    <div class="step-image-wrap">
                        <span class="step-number-overlay">05</span>
                        <img
                            src="https://images.unsplash.com/photo-1599629954294-16b391fce923?w=700&q=80"
                            alt="Surveiller la pousse"
                            onerror="this.style.display='none'; this.parentNode.classList.add('no-img'); this.parentNode.innerHTML='<span class=\'step-number-overlay\'>05</span>🔍';"
                        >
                    </div>
                    <div class="step-content">
                        <span class="step-tag"><span class="step-tag-dot"></span>étape 05</span>
                        <h2 class="step-name">surveiller & chouchouter</h2>
                        <p class="step-joke">"8 à 10 semaines de suspense insoutenable."</p>
                        <p class="step-desc">
                            Fertilisez à l'azote 3 semaines après le repiquage.
                            Vérifiez la présence d'altises et de chenilles.
                            Buttez légèrement pour soutenir les tiges. Votre brocoli
                            vous observe. Il juge.
                        </p>
                        <div class="step-badge">
                            <span class="step-badge-pill">fertilisation azotée</span>
                            <span class="step-badge-pill">surveiller les ravageurs</span>
                        </div>
                    </div>
                </div>

                <!-- Étape 6 -->
                <div class="step-card reverse">
                    <div class="step-image-wrap">
                        <span class="step-number-overlay">06</span>
                        <img
                            src="https://images.unsplash.com/photo-1459411621453-7b03977f4bfc?w=700&q=80"
                            alt="Récolte du brocoli"
                            onerror="this.style.display='none'; this.parentNode.classList.add('no-img'); this.parentNode.innerHTML='<span class=\'step-number-overlay\'>06</span>🥦';"
                        >
                    </div>
                    <div class="step-content">
                        <span class="step-tag"><span class="step-tag-dot"></span>étape 06</span>
                        <h2 class="step-name">récolter le triomphe</h2>
                        <p class="step-joke">"La gloire éternelle vous appartient. Et un bon gratin aussi."</p>
                        <p class="step-desc">
                            Récoltez quand la tête est bien compacte, d'un vert intense,
                            avant que les boutons floraux ne s'ouvrent. Coupez en biais
                            à 15 cm de tige. Les jets latéraux repousseront — vous êtes
                            désormais un jardinier.
                        </p>
                        <div class="step-badge">
                            <span class="step-badge-pill">tête compacte & verte</span>
                            <span class="step-badge-pill">coupe en biais</span>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
    <script src="/js/recipe.js"></script>
</body>
</html>
