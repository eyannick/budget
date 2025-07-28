<?php
require_once __DIR__.'/../includes/auth.php';
require_login();
$db = getDB();
$id = (int)($_GET['id'] ?? 0);
$query = 'SELECT s.name, s.category_id FROM subcategories s JOIN categories c ON s.category_id=c.id WHERE s.id=? AND c.user_id=?';
$stmt = $db->prepare($query);
$stmt->execute([$id, current_user_id()]);
$row = $stmt->fetch();
if (!$row) {
    header('Location: list.php');
    exit;
}

$stmt2 = $db->prepare('SELECT id, name FROM categories WHERE user_id = ? ORDER BY name');
$stmt2->execute([current_user_id()]);
$categories = $stmt2->fetchAll();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $category_id = (int)($_POST['category_id'] ?? 0);
    if ($name && $category_id) {
        $stmt = $db->prepare('UPDATE subcategories SET category_id=?, name=? WHERE id=?');
        $stmt->execute([$category_id, $name, $id]);
        header('Location: list.php');
        exit;
    } else {
        $error = 'Tous les champs sont requis';
    }
}
require_once __DIR__.'/../includes/header.php';
?>
<h1>Éditer la sous-catégorie</h1>
<?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post">
    <div class="mb-3">
        <label class="form-label">Catégorie</label>
        <select name="category_id" class="form-select" required>
            <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>"<?= $cat['id']==$row['category_id']?' selected':'' ?>><?= htmlspecialchars($cat['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Nom</label>
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($row['name']) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Enregistrer</button>
    <a href="list.php" class="btn btn-secondary">Retour</a>
</form>
<?php require_once __DIR__.'/../includes/footer.php';