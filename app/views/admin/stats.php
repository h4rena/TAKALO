<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Statistiques - Admin</title>
  <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
<div class="container">
  <?php $pageTitle = 'Statistiques'; ?>
  <?php include __DIR__ . '/../partials/header_admin.php'; ?>

  <?php if (!empty($error)): ?>
    <div class="flash error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
  <?php endif; ?>

  <div class="grid grid-2">
    <div class="card">
      <span class="badge">Utilisateurs inscrits</span>
      <h2 style="margin: 12px 0 0; font-size: 2.2rem;">
        <?= htmlspecialchars((string) $totalUsers, ENT_QUOTES, 'UTF-8') ?>
      </h2>
      <p class="muted" style="margin: 6px 0 0; color: var(--muted);">Total des comptes enregistrés.</p>
    </div>
  </div>
</div>
</body>
</html>
