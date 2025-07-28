<h2 class="mb-4">Ajouter une catégorie ou sous-catégorie</h2>

<?php if ($message): ?>
  <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<form method="post" class="row g-3">
  <div class="col-md-6">
    <label for="name" class="form-label">Nom</label>
    <input type="text" class="form-control" id="name" name="name" required>
  </div>
  <div class="col-md-6">
    <label for="parent_id" class="form-label">Catégorie parente (laisser vide si c'est une catégorie principale)</label>
    <select class="form-select" id="parent_id" name="parent_id">
      <option value="">Aucune</option>
      <?php foreach ($parentCategories as $cat): ?>
        <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-success">Ajouter</button>
  </div>
</form>
