<h2 class="mb-4">Liste des catégories</h2>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>Nom</th>
      <th>Type</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($categories as $cat): ?>
      <tr>
        <td><?php echo htmlspecialchars($cat['name']); ?></td>
        <td><?php echo is_null($cat['parent_id']) ? 'Catégorie' : 'Sous-catégorie'; ?></td>
        <td>
          <a href="#" class="btn btn-sm btn-primary disabled">Modifier</a>
          <a href="#" class="btn btn-sm btn-danger disabled">Supprimer</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
