<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars((string) $object->nom_objet, ENT_QUOTES, 'UTF-8') ?> - Takalo</title>
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
    <div class="title">Détails Objet</div>
    <nav>
      <a href="/home">Retour</a>
      <?php if ($isAdmin): ?>
        <a href="/admin/categories">Admin</a>
      <?php endif; ?>
    </nav>
  </header>

  <?php if (!empty($error)): ?>
    <div class="flash error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
  <?php endif; ?>
  <?php if (!empty($success)): ?>
    <div class="flash success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
  <?php endif; ?>

  <div class="card">
    <?php
      $mainPhoto = '';
      if (!empty($photos) && !empty($photos[0]->filename)) {
        $mainPhoto = (string) $photos[0]->filename;
      } elseif (!empty($object->image)) {
        $mainPhoto = (string) $object->image;
      }
    ?>
    <div class="object-detail">
      <div>
        <h1><?= htmlspecialchars((string) $object->nom_objet, ENT_QUOTES, 'UTF-8') ?></h1>
        <p><strong>Propriétaire:</strong> <?= htmlspecialchars((string) $object->username, ENT_QUOTES, 'UTF-8') ?> </p>
        <p><strong>Prix estimatif:</strong> <?= htmlspecialchars(number_format((float) $object->price, 2), ENT_QUOTES, 'UTF-8') ?> €</p>
        <?php if (!empty($object->categorie_nom)): ?>
          <p><strong>Catégorie:</strong> <span class="badge"><?= htmlspecialchars((string) $object->categorie_nom, ENT_QUOTES, 'UTF-8') ?></span></p>
        <?php endif; ?>
        <p><?= nl2br(htmlspecialchars((string) ($object->description ?? ''), ENT_QUOTES, 'UTF-8')) ?></p>
      </div>

      <div>
        <?php if ($mainPhoto !== ''): ?>
          <img class="object-hero" src="/assets/uploads/<?= htmlspecialchars($mainPhoto, ENT_QUOTES, 'UTF-8') ?>" alt="Photo">
        <?php endif; ?>

        <?php if (!empty($photos)): ?>
          <div class="object-thumbs">
            <?php foreach ($photos as $photo): ?>
              <img src="/assets/uploads/<?= htmlspecialchars((string) $photo->filename, ENT_QUOTES, 'UTF-8') ?>" alt="Photo">
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <br>

  <div class="card">
    <h2>Proposer un échange</h2>
    <?php if (empty($my_objects)): ?>
      <p>Tu dois avoir au moins un objet pour proposer un échange. <a href="/objects/create">Créer un objet</a></p>
    <?php else: ?>
      <form action="/objects/<?= (int) $object->id ?>/propose" method="post">
        <label>Choisis ton objet à proposer</label>
        <select name="proposed_id" required>
          <option value="">-- Sélectionne --</option>
          <?php foreach ($my_objects as $mine): ?>
            <option value="<?= (int) $mine->id ?>">
              <?= htmlspecialchars((string) $mine->nom_objet, ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars(number_format((float) $mine->price, 2), ENT_QUOTES, 'UTF-8') ?> €)
            </option>
          <?php endforeach; ?>
        </select>
        <button type="submit">Proposer</button>
      </form>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
