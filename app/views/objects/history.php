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
    <style>
        .history-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
        }

        .object-header {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 30px;
            margin-bottom: 40px;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
        }

        .object-image-container {
            border-radius: 8px;
            overflow: hidden;
        }

        .object-image {
            width: 100%;
            height: auto;
            display: block;
        }

        .object-details h1 {
            font-size: 28px;
            margin: 0 0 15px 0;
            color: #333;
        }

        .object-details-info {
            display: grid;
            gap: 15px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: bold;
            color: #555;
        }

        .detail-value {
            color: #333;
            text-align: right;
        }

        .price {
            font-size: 18px;
            color: #27ae60;
            font-weight: bold;
        }

        .history-title {
            font-size: 24px;
            margin: 40px 0 20px 0;
            color: #333;
        }

        .history-timeline {
            position: relative;
            padding-left: 30px;
        }

        .history-timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #3498db;
        }

        .history-item {
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 20px;
        }

        .history-item::before {
            content: '';
            position: absolute;
            left: -18px;
            top: 6px;
            width: 14px;
            height: 14px;
            background: #3498db;
            border: 3px solid white;
            border-radius: 50%;
        }

        .history-card {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
        }

        .history-owner {
            font-weight: bold;
            font-size: 16px;
            color: #333;
            margin-bottom: 8px;
        }

        .history-date {
            font-size: 13px;
            color: #999;
        }

        .history-email {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #3498db;
            text-decoration: none;
            font-size: 14px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .current-owner {
            background: #e8f5e9;
            border-color: #27ae60;
        }

        @media (max-width: 768px) {
            .object-header {
                grid-template-columns: 1fr;
            }

            .detail-row {
                flex-direction: column;
            }

            .detail-value {
                text-align: left;
                margin-top: 5px;
            }
        }
    </style>
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
