<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
$isAdmin = !empty($_SESSION['user']) && (int) ($_SESSION['user']['role_id'] ?? 0) === 1;
?>
<header>
  <div class="title"><?= htmlspecialchars($pageTitle ?? 'Takalo', ENT_QUOTES, 'UTF-8') ?></div>
  <nav>
    <a href="/home">Accueil</a>
    <a href="/objects/mine">Mes Objets</a>
    <a href="/exchanges">Échanges</a>
    <?php if ($isAdmin): ?>
      <a href="/admin/stats">Admin</a>
    <?php endif; ?>
    <a href="/logout">Déconnexion</a>
  </nav>
</header>
