<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mes Échanges - Takalo</title>
  <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
<div class="container">
  <?php $pageTitle = 'Mes Échanges'; ?>
  <?php include __DIR__ . '/../partials/header.php'; ?>

  <?php if (!empty($error)): ?>
    <div class="flash error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
  <?php endif; ?>
  <?php if (!empty($success)): ?>
    <div class="flash success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
  <?php endif; ?>

  <div class="card">
    <h2>Propositions reçues</h2>
    <?php
    $received = array_filter($exchanges, fn($e) => (int) $e->demande_owner_id === (int) $user_id);
    ?>
    <?php if (empty($received)): ?>
      <p>Aucune proposition reçue.</p>
    <?php else: ?>
      <div class="list">
        <?php foreach ($received as $ex): ?>
          <div class="item">
            <p><strong><?= htmlspecialchars((string) $ex->propose_owner_name, ENT_QUOTES, 'UTF-8') ?></strong> propose <strong><?= htmlspecialchars((string) $ex->objet_propose, ENT_QUOTES, 'UTF-8') ?></strong> contre ton objet <strong><?= htmlspecialchars((string) $ex->objet_demande, ENT_QUOTES, 'UTF-8') ?></strong></p>
            <p>Statut: <span class="badge"><?= htmlspecialchars((string) $ex->status, ENT_QUOTES, 'UTF-8') ?></span></p>
            <p>Date: <?= htmlspecialchars((string) $ex->created_at, ENT_QUOTES, 'UTF-8') ?></p>
            <?php if ((string) $ex->status === 'pending'): ?>
              <div class="actions">
                <form action="/exchanges/<?= (int) $ex->id ?>/accept" method="post" style="display:inline;">
                  <button type="submit">Accepter</button>
                </form>
                <form action="/exchanges/<?= (int) $ex->id ?>/refuse" method="post" style="display:inline;">
                  <button type="submit" class="secondary">Refuser</button>
                </form>
              </div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <br>

  <div class="card">
    <h2>Propositions envoyées</h2>
    <?php
    $sent = array_filter($exchanges, fn($e) => (int) $e->propose_owner_id === (int) $user_id);
    ?>
    <?php if (empty($sent)): ?>
      <p>Aucune proposition envoyée.</p>
    <?php else: ?>
      <div class="list">
        <?php foreach ($sent as $ex): ?>
          <div class="item">
            <p>Tu as proposé <strong><?= htmlspecialchars((string) $ex->objet_propose, ENT_QUOTES, 'UTF-8') ?></strong> contre <strong><?= htmlspecialchars((string) $ex->objet_demande, ENT_QUOTES, 'UTF-8') ?></strong> de <strong><?= htmlspecialchars((string) $ex->demande_owner_name, ENT_QUOTES, 'UTF-8') ?></strong></p>
            <p>Statut: <span class="badge"><?= htmlspecialchars((string) $ex->status, ENT_QUOTES, 'UTF-8') ?></span></p>
            <p>Date: <?= htmlspecialchars((string) $ex->created_at, ENT_QUOTES, 'UTF-8') ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
