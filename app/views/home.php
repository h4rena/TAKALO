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
      <a href="/objects">Objets</a>
      <a href="/exchanges">Échanges</a>
      <?php if ((int) ($user['role_id'] ?? 0) === 1): ?>
        <a href="/admin/categories">Admin</a>
      <?php endif; ?>
      <a href="/logout">Déconnexion</a>
    </nav>
  </header>

  <div class="card">
    <h2>Bienvenue sur Takalo !</h2>
    
    <div style="margin: 20px 0; padding: 20px; background: #f9f9f9; border-radius: 8px;">
      <h3 style="margin-top: 0;">Rechercher un objet</h3>
      <form method="get" action="/home" style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 15px; align-items: end;">
        <div>
          <label style="display: block; margin-bottom: 5px; font-weight: bold; font-size: 14px;">Titre ou description</label>
          <input type="text" name="q" placeholder="Chercher un objet..." value="<?= htmlspecialchars($query ?? '', ENT_QUOTES, 'UTF-8') ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
        </div>
        <div>
          <label style="display: block; margin-bottom: 5px; font-weight: bold; font-size: 14px;">Catégorie</label>
          <select name="category_id" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
            <option value="0">-- Toutes les catégories --</option>
            <?php foreach ($categories as $cat): ?>
              <option value="<?= (int)$cat['id'] ?>" <?= ((int)($selected_category_id ?? 0) === (int)$cat['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['nom'], ENT_QUOTES, 'UTF-8') ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div>
          <button type="submit" style="padding: 10px 20px; background: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Rechercher</button>
        </div>
      </form>
    </div>
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
