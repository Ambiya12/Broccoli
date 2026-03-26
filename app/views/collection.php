<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collection — Broccoli</title>
    <link rel="stylesheet" href="/css/home.css">
    <style>
        .site-wrapper {
            overflow-y: auto;
            justify-content: flex-start;
        }
        .collection-main {
            z-index: 10;
            position: relative;
            flex: 1;
            padding: 40px 0 20px;
        }
        .collection-title {
            font-size: 2.2rem;
            font-weight: 900;
            letter-spacing: -0.03em;
            margin: 0 0 30px 0;
            text-transform: lowercase;
        }
        .collection-empty {
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            opacity: 0.4;
        }
        .collection-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 16px;
        }
        .collection-item {
            border: 1px solid rgba(0,0,0,0.15);
            border-radius: 16px;
            padding: 12px;
            background: rgba(255,255,255,0.4);
            backdrop-filter: blur(10px);
            display: flex;
            flex-direction: column;
            gap: 8px;
            transition: border-color 0.2s;
        }
        .collection-item:hover {
            border-color: #111;
        }
        .collection-item img {
            width: 100%;
            aspect-ratio: 1;
            object-fit: cover;
            border-radius: 10px;
        }
        .collection-item-name {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: lowercase;
            opacity: 0.7;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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
                <a href="#">recipe</a>
                <a href="#">fun fact</a>
                <a href="/collection" class="active">collection</a>
            </nav>
            <div class="main-nav">
                <a href="/login">login</a>
            </div>
        </header>

        <main class="collection-main">
            <h1 class="collection-title">collection</h1>
            <?php if (empty($images)): ?>
                <p class="collection-empty">aucune image trouvée.</p>
            <?php else: ?>
                <div class="collection-grid">
                    <?php foreach ($images as $image): ?>
                        <?php $baseName = pathinfo($image['name'], PATHINFO_FILENAME); ?>
                        <div class="collection-item">
                            <img
                                src="/uploads/<?= htmlspecialchars($image['name']) ?>"
                                alt="<?= htmlspecialchars($baseName) ?>"
                            >
                            <span class="collection-item-name"><?= htmlspecialchars($baseName) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
