<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des Catégories - Admin</title>
  <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
<div class="container">
  <header>
    <div class="title">Gestion des Catégories</div>
    <nav>
      <a href="/admin/stats">Statistiques</a>
      <a href="/admin/categories">Catégories</a>
      <a href="/admin/logout">Déconnexion</a>
    </nav>
  </header>

  <?php if (!empty($error)): ?>
    <div class="flash error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
  <?php endif; ?>
  <?php if (!empty($success)): ?>
    <div class="flash success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
  <?php endif; ?>

  <div class="card">
    <h2>Ajouter une catégorie</h2>
    <form action="/admin/categories" method="post">
      <input type="text" name="name" placeholder="Nom de la catégorie" required />
      <button type="submit">Ajouter</button>
    </form>
  </div>

  <br>

  <div class="card">
    <h2>Liste des catégories</h2>
    <?php if (empty($categories)): ?>
      <p>Aucune catégorie pour le moment.</p>
    <?php else: ?>
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($categories as $cat): ?>
            <tr>
              <td><?= htmlspecialchars((string) $cat->id, ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars((string) $cat->nom, ENT_QUOTES, 'UTF-8') ?></td>
              <td>
                <div class="actions">
                  <form action="/admin/categories/<?= (int) $cat->id ?>/edit" method="get" style="display:inline;">
                    <button type="submit" class="secondary">Modifier</button>
                  </form>
                  <form action="/admin/categories/<?= (int) $cat->id ?>/delete" method="post" style="display:inline;">
                    <button type="submit" onclick="return confirm('Supprimer ?');">Supprimer</button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
