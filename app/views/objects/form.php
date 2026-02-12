<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= ($mode === 'create' ? 'Nouvel' : 'Modifier') ?> Objet - Takalo</title>
  <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
<div class="container">
  <header>
    <div class="title"><?= htmlspecialchars($mode === 'create' ? 'Nouvel Objet' : 'Modifier Objet', ENT_QUOTES, 'UTF-8') ?></div>
    <nav>
      <a href="/objects/mine">Retour</a>
    </nav>
  </header>

  <?php if (!empty($error)): ?>
    <div class="flash error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
  <?php endif; ?>

  <div class="card">
    <form action="<?= $mode === 'create' ? '/objects' : '/objects/' . (int) $object->id ?>" method="post" enctype="multipart/form-data">
      <label>Titre *</label>
      <input type="text" name="name" value="<?= htmlspecialchars((string) ($object->nom_objet ?? ''), ENT_QUOTES, 'UTF-8') ?>" required />

      <label>Description</label>
      <textarea name="description"><?= htmlspecialchars((string) ($object->description ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>

      <label>Prix estimatif (Ar) *</label>
      <input type="number" step="0.01" name="price" value="<?= htmlspecialchars((string) ($object->price ?? ''), ENT_QUOTES, 'UTF-8') ?>" required />

      <label>Catégorie</label>
      <select name="category_id">
        <option value="">-- Aucune --</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= (int) $cat->id ?>" <?= (isset($object->id_categorie) && (int) $object->id_categorie === (int) $cat->id) ? 'selected' : '' ?>>
            <?= htmlspecialchars((string) $cat->nom, ENT_QUOTES, 'UTF-8') ?>
          </option>
        <?php endforeach; ?>
      </select>

      <label>Photos <?= $mode === 'create' ? '*' : '(ajouter de nouvelles)' ?></label>
      <input type="file" name="photos[]" accept="image/*" multiple <?= $mode === 'create' ? 'required' : '' ?> />

      <?php if ($mode === 'edit' && !empty($photos)): ?>
        <div class="gallery">
          <?php foreach ($photos as $photo): ?>
            <img src="/assets/uploads/<?= htmlspecialchars((string) $photo->filename, ENT_QUOTES, 'UTF-8') ?>" alt="Photo">
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <button type="submit"><?= htmlspecialchars($mode === 'create' ? 'Créer' : 'Mettre à jour', ENT_QUOTES, 'UTF-8') ?></button>
    </form>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>

</body>
</html>
