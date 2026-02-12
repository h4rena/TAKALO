<?php
$title = 'Recherche';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="/assets/css/app.css">
    <style>
        .search-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
        }

        .search-form {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 15px;
            align-items: end;
        }

        .search-form input,
        .search-form select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .search-form button {
            padding: 10px 20px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .search-form button:hover {
            background: #2980b9;
        }

        .objects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .object-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            background: white;
            transition: box-shadow 0.3s;
        }

        .object-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .object-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: #f0f0f0;
        }

        .object-info {
            padding: 15px;
        }

        .object-name {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 8px;
            color: #333;
        }

        .object-category {
            font-size: 12px;
            color: #999;
            margin-bottom: 8px;
        }

        .object-owner {
            font-size: 13px;
            color: #666;
            margin-bottom: 10px;
        }

        .object-price {
            font-size: 14px;
            font-weight: bold;
            color: #27ae60;
            margin-bottom: 10px;
        }

        .object-actions {
            display: flex;
            gap: 8px;
        }

        .object-actions a {
            flex: 1;
            padding: 8px;
            text-align: center;
            text-decoration: none;
            background: #3498db;
            color: white;
            border-radius: 4px;
            font-size: 12px;
            transition: background 0.3s;
        }

        .object-actions a:hover {
            background: #2980b9;
        }

        .no-results {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        @media (max-width: 768px) {
            .search-form {
                grid-template-columns: 1fr;
            }

            .objects-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
        }
    </style>
</head>
<body>
    <div class="search-container">
        <h1><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h1>

        <form method="get" action="/objects/search" class="search-form">
            <div>
                <input type="text" name="q" placeholder="Rechercher par titre ou description..." value="<?= htmlspecialchars($query ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div>
                <select name="category_id">
                    <option value="0">-- Toutes les catégories --</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= (int)$category['id'] ?>" <?= ((int)($selected_category_id ?? 0) === (int)$category['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['nom'], ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit">Rechercher</button>
        </form>

        <?php if (count($objects) > 0): ?>
            <div class="objects-grid">
                <?php foreach ($objects as $object): ?>
                    <div class="object-card">
                        <img src="/assets/images/<?= htmlspecialchars($object['image'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($object['nom_objet'], ENT_QUOTES, 'UTF-8') ?>" class="object-image">
                        <div class="object-info">
                            <div class="object-name"><?= htmlspecialchars($object['nom_objet'], ENT_QUOTES, 'UTF-8') ?></div>
                            <?php if ($object['categorie_nom']): ?>
                                <div class="object-category"><?= htmlspecialchars($object['categorie_nom'], ENT_QUOTES, 'UTF-8') ?></div>
                            <?php endif; ?>
                            <div class="object-owner">Par: <?= htmlspecialchars($object['username'], ENT_QUOTES, 'UTF-8') ?></div>
                            <div class="object-price"><?= number_format((float)$object['price'], 2) ?> Ar</div>
                            <div class="object-actions">
                                <a href="/objects/<?= (int)$object['id'] ?>">Voir</a>
                                <a href="/objects/<?= (int)$object['id'] ?>/history">Historique</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-results">
                <p>Aucun objet ne correspond à votre recherche.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
