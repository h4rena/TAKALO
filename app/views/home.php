<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil - Takalo</title>
  <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
<div class="container">
  <header>
    <div class="title">Bienvenue <?= htmlspecialchars($user['username'] ?? 'Utilisateur', ENT_QUOTES, 'UTF-8') ?></div>
    <nav>
      <a href="/home">Accueil</a>
      <a href="/objects/mine">Mes Objets</a>
      <a href="/exchanges">Échanges</a>
      <?php if ((int) ($user['role_id'] ?? 0) === 1): ?>
        <a href="/admin/categories">Admin</a>
      <?php endif; ?>
      <a href="/logout">Déconnexion</a>
    </nav>
  </header>

  <div class="card">
    <h2>Bienvenue sur Takalo !</h2>
  </div>

  <br>

  <div class="card">
    <h2>Objets disponibles</h2>
    <?php if (empty($objects)): ?>
      <p>Aucun objet disponible.</p>
    <?php else: ?>
      <div class="grid grid-3">
        <?php foreach ($objects as $obj): ?>
          <div class="object-card">
            <?php if (!empty($obj->image)): ?>
              <center>              <img class="object-thumb" src="/assets/uploads/<?= htmlspecialchars((string) $obj->image, ENT_QUOTES, 'UTF-8') ?>" alt="Photo">
</center>
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
            <form action="/objects/<?= (int) $obj->id ?>" method="get" class="actions">
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
