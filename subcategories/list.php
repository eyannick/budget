<?php
require_once __DIR__.'/../includes/auth.php';
require_login();
$db = getDB();

if (isset($_POST['delete'])) {
    $stmt = $db->prepare('DELETE FROM subcategories WHERE id = ?');
    $stmt->execute([$_POST['delete']]);
}

$query = 'SELECT s.id, s.name, c.name AS category
          FROM subcategories s
          JOIN categories c ON s.category_id = c.id
          WHERE c.user_id = ?
          ORDER BY c.name, s.name';
$stmt = $db->prepare($query);
$stmt->execute([current_user_id()]);
$rows = $stmt->fetchAll();

require_once __DIR__.'/../includes/header.php';
?>
<h1>Sous-catégories</h1>
<a href="add.php" class="btn btn-primary mb-3">Ajouter</a>
<table class="table">
  <tr><th>Catégorie</th><th>Nom</th><th>Actions</th></tr>
  <?php foreach ($rows as $row): ?>
  <tr>
    <td><?= htmlspecialchars($row['category']) ?></td>
    <td><?= htmlspecialchars($row['name']) ?></td>
    <td>
      <a class="btn btn-sm btn-secondary" href="edit.php?id=<?= $row['id'] ?>">Éditer</a>
      <form method="post" class="d-inline" onsubmit="return confirm('Supprimer ?');">
        <input type="hidden" name="delete" value="<?= $row['id'] ?>">
        <button class="btn btn-sm btn-danger">Supprimer</button>
      </form>
    </td>
  </tr>
  <?php endforeach; ?>
</table>
<<<<<<< HEAD
<?php require_once __DIR__.'/../includes/footer.php';
=======
<?php require_once __DIR__.'/../includes/footer.php';
>>>>>>> 56ad122dbfc9a25313c64344091314310913a7af
