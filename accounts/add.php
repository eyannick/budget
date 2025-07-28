<?php
require_once dirname(__DIR__).'/includes/auth.php';
require_login();
$db = getDB();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    if ($name) {
        $stmt = $db->prepare('INSERT INTO accounts (user_id, name) VALUES (?, ?)');
        $stmt->execute([current_user_id(), $name]);
        header('Location: list.php');
        exit;
    } else {
        $error = 'Nom requis';
    }
}
require_once dirname(__DIR__).'/includes/header.php';
?>
<h1>Ajouter un compte</h1>
<?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post">
    <div class="mb-3">
        <label class="form-label">Nom</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Enregistrer</button>
    <a href="list.php" class="btn btn-secondary">Retour</a>
</form>
<?php require_once dirname(__DIR__).'/includes/footer.php';