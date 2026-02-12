<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin - Takalo</title>
  <link rel="stylesheet" href="/assets/css/login.css">
</head>
<body>
<div class="container" id="container">
  <div class="form-container sign-in-container">
    <form action="/admin/login" method="post" novalidate>
      <h1>Admin Login</h1>
      <span>Connectez-vous avec les identifiants admin</span>
      <?php if (!empty($error)): ?>
        <p class="error" style="color: #c0392b; margin: 8px 0;">
          <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </p>
      <?php endif; ?>
      <input type="email" name="email" placeholder="Email admin" value="<?= htmlspecialchars($default_email ?? '', ENT_QUOTES, 'UTF-8') ?>" required />
      <input type="password" name="password" placeholder="Mot de passe" minlength="6" required />
      <button type="submit">Sign In</button>
    </form>
  </div>
  <div class="overlay-container">
    <div class="overlay">
      <div class="overlay-panel overlay-right">
        <h1>Backoffice</h1>
        <p>Administration des catégories et du système</p>
    </form>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>

</body>
</html>
