<?php
$title = 'Historique d\'appartenance';
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
    <div class="history-container">
        <a href="/objects" class="back-link">&larr; Retour à la liste</a>

        <div class="object-header">
            <div class="object-image-container">
                <img src="/assets/images/<?= htmlspecialchars($object['image'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($object['nom_objet'], ENT_QUOTES, 'UTF-8') ?>" class="object-image">
            </div>
            <div class="object-details">
                <h1><?= htmlspecialchars($object['nom_objet'], ENT_QUOTES, 'UTF-8') ?></h1>
                <div class="object-details-info">
                    <div class="detail-row">
                        <span class="detail-label">Catégorie</span>
                        <span class="detail-value">
                            <?= $object['categorie_nom'] ? htmlspecialchars($object['categorie_nom'], ENT_QUOTES, 'UTF-8') : 'Non catégorisé' ?>
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Propriétaire actuel</span>
                        <span class="detail-value"><?= htmlspecialchars($object['username'], ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Prix</span>
                        <span class="detail-value price"><?= number_format((float)$object['price'], 2) ?> Ar</span>
                    </div>
                </div>
                <?php if ($object['description']): ?>
                    <div style="margin-top: 20px; font-size: 14px; color: #555; line-height: 1.6;">
                        <?= nl2br(htmlspecialchars($object['description'], ENT_QUOTES, 'UTF-8')) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <h2 class="history-title">📜 Historique d'appartenance</h2>

        <?php if (count($history) > 0): ?>
            <div class="history-timeline">
                <?php foreach ($history as $index => $entry): ?>
                    <div class="history-item">
                        <div class="history-card <?= ($index === count($history) - 1) ? 'current-owner' : '' ?>">
                            <div class="history-owner"><?= htmlspecialchars($entry['username'], ENT_QUOTES, 'UTF-8') ?></div>
                            <div class="history-date">
                                <?= date('d/m/Y à H:i', strtotime($entry['changed_at'])) ?>
                            </div>
                            <div class="history-email">
                                <?= htmlspecialchars($entry['email'], ENT_QUOTES, 'UTF-8') ?>
                            </div>
                            <?php if ($index === count($history) - 1): ?>
                                <div style="margin-top: 8px; font-size: 12px; color: #27ae60; font-weight: bold;">
                                    Propriétaire actuel
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 40px; color: #999;">
                <p>Aucun historique d'appartenance enregistré.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
