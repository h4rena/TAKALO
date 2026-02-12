<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Objets Disponibles - Takalo</title>
  <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
<?php
$isAdmin = false;
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
$isAdmin = !empty($_SESSION['user']) && (int) ($_SESSION['user']['role_id'] ?? 0) === 1;
?>
<div class="container">
  <header>
    <div class="title">Objets Disponibles</div>
    <nav>
      <a href="/home">Accueil</a>
      <a href="/objects/mine">Mes Objets</a>
      <a href="/objects">Objets</a>
      <a href="/exchanges">Échanges</a>
      <?php if ($isAdmin): ?>
        <a href="/admin/categories">Admin</a>
      <?php endif; ?>
      <a href="/logout">Déconnexion</a>
    </nav>
  </header>

  <div class="card">
    <h2>Liste des objets</h2>
    
    <div style="margin-bottom: 20px; padding: 15px; background: #f9f9f9; border-radius: 8px;">
      <form method="get" action="/objects/search" style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 10px; align-items: end;">
        <div>
          <input type="text" name="q" placeholder="Rechercher par titre..." style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        <div>
          <button type="submit" style="padding: 8px 15px; background: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer; width: 100%;">Rechercher</button>
        </div>
      </form>
    </div>
    
    <?php if (empty($objects)): ?>
      <p>Aucun objet disponible.</p>
    <?php else: ?>
      <div class="grid grid-3">
        <?php foreach ($objects as $obj): ?>
          <div class="object-card">
            <?php if (!empty($obj->image)): ?>
              <img class="object-thumb" src="/assets/uploads/<?= htmlspecialchars((string) $obj->image, ENT_QUOTES, 'UTF-8') ?>" alt="Photo">
            <?php endif; ?>
            <div class="meta">
              <h3><?= htmlspecialchars((string) $obj->nom_objet, ENT_QUOTES, 'UTF-8') ?></h3>
              <p><strong>Par:</strong> <?= htmlspecialchars((string) $obj->username, ENT_QUOTES, 'UTF-8') ?></p>
              <p><?= htmlspecialchars(mb_substr((string) ($obj->description ?? ''), 0, 90), ENT_QUOTES, 'UTF-8') ?></p>
              <p><strong>Prix:</strong> <?= htmlspecialchars(number_format((float) $obj->price, 2), ENT_QUOTES, 'UTF-8') ?> €</p>
              <?php if (!empty($obj->categorie_nom)): ?>
                <span class="badge"><?= htmlspecialchars((string) $obj->categorie_nom, ENT_QUOTES, 'UTF-8') ?></span>
              <?php endif; ?>
            </div>
            <div class="actions" style="display: flex; gap: 8px;">
              <form action="/objects/<?= (int) $obj->id ?>" method="get" style="flex: 1;">
                <button type="submit" class="secondary" style="width: 100%;">Voir Détails</button>
              </form>
              <form action="/objects/<?= (int) $obj->id ?>/history" method="get" style="flex: 1;">
                <button type="submit" class="secondary" style="width: 100%;">Historique</button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
