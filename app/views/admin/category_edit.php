<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier Catégorie - Admin</title>
  <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
<div class="container">
  <header>
    <div class="title">Modifier Catégorie</div>
    <nav>
      <a href="/admin/categories">Retour</a>
    </nav>
  </header>

  <?php if (!empty($error)): ?>
    <div class="flash error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
  <?php endif; ?>

  <div class="card">
    <form action="/admin/categories/<?= (int) $category->id ?>/update" method="post">
      <label>Nom de la catégorie</label>
      <input type="text" name="name" value="<?= htmlspecialchars((string) $category->nom, ENT_QUOTES, 'UTF-8') ?>" required />
      <button type="submit">Mettre à jour</button>
    </form>
  </div>
</div>
</body>
</html>
