<?php
require_once dirname(__DIR__).'/includes/auth.php';
require_login();
$db = getDB();
$id = (int)($_GET['id'] ?? 0);
$stmt = $db->prepare('SELECT name FROM accounts WHERE id=? AND user_id=?');
$stmt->execute([$id, current_user_id()]);
$row = $stmt->fetch();
if (!$row) { header('Location: list.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    if ($name) {
        $stmt = $db->prepare('UPDATE accounts SET name=? WHERE id=? AND user_id=?');
        $stmt->execute([$name, $id, current_user_id()]);
        header('Location: list.php');
        exit;
    } else {
        $error = 'Nom requis';
    }
}
require_once dirname(__DIR__).'/includes/header.php';
?>
<h1>Éditer le compte</h1>
<?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post">
<div class="mb-3">
  <label class="form-label">Nom</label>
  <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($row['name']) ?>" required>
</div>
<button type="submit" class="btn btn-primary">Enregistrer</button>
<a href="list.php" class="btn btn-secondary">Retour</a>
</form>
<?php require_once dirname(__DIR__).'/includes/footer.php';