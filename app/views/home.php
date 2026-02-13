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
      <a href="/logout">Déconnexion</a>
    </nav>
  </header>

  <div class="card">
    <h2>Bienvenue sur Takalo !</h2>
    <p>Gérez vos objets, parcourez les objets disponibles et proposez des échanges.</p>
    <div class="actions">
      <form action="/objects/mine" method="get"><button type="submit">Mes Objets</button></form>
      <form action="/objects" method="get"><button type="submit" class="secondary">Voir les Objets</button></form>
      <form action="/exchanges" method="get"><button type="submit" class="secondary">Mes Échanges</button></form>
    </div>
  </div>
</div>
</body>
</html>
