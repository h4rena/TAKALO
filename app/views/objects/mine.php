<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mes Objets - Takalo</title>
  <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
<div class="container">
  <header>
    <div class="title">Mes Objets</div>
    <nav>
      <a href="/home">Accueil</a>
      <a href="/objects/mine">Mes Objets</a>
      <a href="/objects">Objets</a>
      <a href="/exchanges">Échanges</a>
      <a href="/logout">Déconnexion</a>
    </nav>
  </header>

  <?php if (!empty($error)): ?>
    <div class="flash error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
  <?php endif; ?>
  <?php if (!empty($success)): ?>
    <div class="flash success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
  <?php endif; ?>

  <div class="card">
    <h2>Ajouter un objet</h2>
    <form action="/objects/create" method="get">
      <button type="submit">Nouvel Objet</button>
    </form>
  </div>

  <br>

  <div class="card">
    <h2>Mes objets</h2>
    <?php if (empty($objects)): ?>
      <p>Aucun objet pour le moment.</p>
    <?php else: ?>
      <div class="list">
        <?php foreach ($objects as $obj): ?>
          <div class="item">
            <h3><?= htmlspecialchars((string) $obj->nom_objet, ENT_QUOTES, 'UTF-8') ?></h3>
            <p><?= htmlspecialchars((string) ($obj->description ?? ''), ENT_QUOTES, 'UTF-8') ?></p>
            <p><strong>Prix:</strong> <?= htmlspecialchars(number_format((float) $obj->price, 2), ENT_QUOTES, 'UTF-8') ?> €</p>
            <?php if (!empty($obj->categorie_nom)): ?>
              <span class="badge"><?= htmlspecialchars((string) $obj->categorie_nom, ENT_QUOTES, 'UTF-8') ?></span>
            <?php endif; ?>
            <div class="actions">
              <form action="/objects/<?= (int) $obj->id ?>/edit" method="get" style="display:inline;">
                <button type="submit" class="secondary">Modifier</button>
              </form>
              <form action="/objects/<?= (int) $obj->id ?>/delete" method="post" style="display:inline;">
                <button type="submit" onclick="return confirm('Supprimer ?');">Supprimer</button>
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
