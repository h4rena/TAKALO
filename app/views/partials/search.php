<div style="margin: 20px 0; padding: 20px; background: #f9f9f9; border-radius: 8px;">
  <h3 style="margin-top: 0;">Rechercher un objet</h3>
  <form method="get" action="/home" style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 15px; align-items: end;">
    <div>
      <label style="display: block; margin-bottom: 5px; font-weight: bold; font-size: 14px;">Titre ou description</label>
      <input type="text" name="q" placeholder="Chercher un objet..." value="<?= htmlspecialchars($query ?? '', ENT_QUOTES, 'UTF-8') ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
    </div>
    <div>
      <label style="display: block; margin-bottom: 5px; font-weight: bold; font-size: 14px;">Catégorie</label>
      <select name="category_id" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
        <option value="0">-- Toutes les catégories --</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= (int)$cat['id'] ?>" <?= ((int)($selected_category_id ?? 0) === (int)$cat['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($cat['nom'], ENT_QUOTES, 'UTF-8') ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div>
      <button type="submit" style="padding: 10px 20px; background: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Rechercher</button>
    </div>
  </form>
</div>
