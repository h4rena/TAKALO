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
</head>
<body>
    <?php $pageTitle = 'Recherche'; ?>
    <?php include __DIR__ . '/../partials/header.php'; ?>
    
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
                        <a href="/objects/<?= (int)$object['id'] ?>" style="display: block; text-decoration: none;">
                            <img src="/assets/images/<?= htmlspecialchars($object['image'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($object['nom_objet'], ENT_QUOTES, 'UTF-8') ?>" class="object-image" style="cursor: pointer;">
                        </a>
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

<?php include __DIR__ . '/../partials/footer.php'; ?>

</body>
</html>
