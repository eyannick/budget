<?php
require_once __DIR__.'/../includes/auth.php';
require_login();
$db = getDB();

$stmt = $db->prepare('SELECT id, name FROM categories WHERE user_id = ? ORDER BY name');
$stmt->execute([current_user_id()]);
$categories = $stmt->fetchAll();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $category_id = (int)($_POST['category_id'] ?? 0);
    if ($name && $category_id) {
        $stmt = $db->prepare('INSERT INTO subcategories (category_id, name) VALUES (?, ?)');
        $stmt->execute([$category_id, $name]);
        header('Location: list.php');
        exit;
    } else {
        $error = 'Tous les champs sont requis';
    }
}
require_once __DIR__.'/../includes/header.php';
?>
<h1>Ajouter une sous-catégorie</h1>
<?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post">
    <div class="mb-3">
        <label class="form-label">Catégorie</label>
        <select name="category_id" class="form-select" required>
            <option value="">Choisir...</option>
            <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Nom</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Enregistrer</button>
    <a href="list.php" class="btn btn-secondary">Retour</a>
</form>
<?php require_once __DIR__.'/../includes/footer.php';