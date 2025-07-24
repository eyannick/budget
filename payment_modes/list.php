<?php
require_once __DIR__.'/../includes/auth.php';
require_login();
$db = getDB();
if (isset($_POST['delete'])) {
    $stmt = $db->prepare('DELETE FROM payment_modes WHERE id=? AND user_id=?');
    $stmt->execute([$_POST['delete'], current_user_id()]);
}
$stmt = $db->prepare('SELECT id, name FROM payment_modes WHERE user_id=? ORDER BY name');
$stmt->execute([current_user_id()]);
$rows = $stmt->fetchAll();
require_once __DIR__.'/../includes/header.php';
?>
<h1>Modes de paiement</h1>
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
<?php require_once __DIR__.'/../includes/footer.php';
