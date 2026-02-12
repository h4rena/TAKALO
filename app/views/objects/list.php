<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Objets Disponibles - Takalo</title>
  <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
<div class="container">
  <header>
    <div class="title">Objets Disponibles</div>
    <nav>
      <a href="/home">Accueil</a>
      <a href="/objects/mine">Mes Objets</a>
      <a href="/objects">Objets</a>
      <a href="/exchanges">Échanges</a>
      <a href="/logout">Déconnexion</a>
    </nav>
  </header>

  <div class="card">
    <h2>Liste des objets</h2>
    <?php if (empty($objects)): ?>
      <p>Aucun objet disponible.</p>
    <?php else: ?>
      <div class="grid grid-2">
        <?php foreach ($objects as $obj): ?>
          <div class="item">
            <h3><?= htmlspecialchars((string) $obj->nom_objet, ENT_QUOTES, 'UTF-8') ?></h3>
            <p><strong>Par:</strong> <?= htmlspecialchars((string) $obj->username, ENT_QUOTES, 'UTF-8') ?></p>
            <p><?= htmlspecialchars(mb_substr((string) ($obj->description ?? ''), 0, 100), ENT_QUOTES, 'UTF-8') ?></p>
            <p><strong>Prix:</strong> <?= htmlspecialchars(number_format((float) $obj->price, 2), ENT_QUOTES, 'UTF-8') ?> €</p>
            <?php if (!empty($obj->categorie_nom)): ?>
              <span class="badge"><?= htmlspecialchars((string) $obj->categorie_nom, ENT_QUOTES, 'UTF-8') ?></span>
            <?php endif; ?>
            <br><br>
            <form action="/objects/<?= (int) $obj->id ?>" method="get">
              <button type="submit" class="secondary">Voir Détails</button>
            </form>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
