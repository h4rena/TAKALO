<header>
  <div class="title"><?= htmlspecialchars($pageTitle ?? 'Admin', ENT_QUOTES, 'UTF-8') ?></div>
  <nav>
    <a href="/admin/stats">Statistiques</a>
    <a href="/admin/categories">Catégories</a>
    <a href="/admin/logout">Déconnexion</a>
  </nav>
</header>
