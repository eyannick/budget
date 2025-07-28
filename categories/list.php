<?php
require_once dirname(__DIR__).'/includes/auth.php';
require_login();
$db = getDB();

if (isset($_POST['delete'])) {
    $stmt = $db->prepare('DELETE FROM categories WHERE id = ? AND user_id = ?');
    $stmt->execute([$_POST['delete'], current_user_id()]);
}

$stmt = $db->prepare('SELECT id, name FROM categories WHERE user_id = ? ORDER BY name');
$stmt->execute([current_user_id()]);
$categories = $stmt->fetchAll();

require_once dirname(__DIR__).'/includes/header.php';
?>
<h1>Catégories</h1>
<a href="add.php" class="btn btn-primary mb-3">Ajouter</a>
<table class="table">
    <tr><th>Nom</th><th>Actions</th></tr>
    <?php foreach ($categories as $cat): ?>
    <tr>
        <td><?= htmlspecialchars($cat['name']) ?></td>
        <td>
            <a class="btn btn-sm btn-secondary" href="edit.php?id=<?= $cat['id'] ?>">Éditer</a>
            <form method="post" class="d-inline" onsubmit="return confirm('Supprimer ?');">
                <input type="hidden" name="delete" value="<?= $cat['id'] ?>">
                <button class="btn btn-sm btn-danger">Supprimer</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php require_once dirname(__DIR__).'/includes/footer.php';