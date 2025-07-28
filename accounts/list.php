<?php
<<<<<<< HEAD
require_once dirname(__DIR__).'/includes/auth.php';
=======
require_once __DIR__.'/../includes/auth.php';
>>>>>>> 56ad122dbfc9a25313c64344091314310913a7af
require_login();
$db = getDB();
if (isset($_POST['delete'])) {
    $stmt = $db->prepare('DELETE FROM accounts WHERE id=? AND user_id=?');
    $stmt->execute([$_POST['delete'], current_user_id()]);
}
$stmt = $db->prepare('SELECT id, name FROM accounts WHERE user_id=? ORDER BY name');
$stmt->execute([current_user_id()]);
$rows = $stmt->fetchAll();
<<<<<<< HEAD
require_once dirname(__DIR__).'/includes/header.php';
=======
require_once __DIR__.'/../includes/header.php';
>>>>>>> 56ad122dbfc9a25313c64344091314310913a7af
?>
<h1>Comptes</h1>
<a href="add.php" class="btn btn-primary mb-3">Ajouter</a>
<table class="table">
<tr><th>Nom</th><th>Actions</th></tr>
<?php foreach ($rows as $row): ?>
<tr>
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
<?php require_once dirname(__DIR__).'/includes/footer.php';
=======
<?php require_once __DIR__.'/../includes/footer.php';
>>>>>>> 56ad122dbfc9a25313c64344091314310913a7af
