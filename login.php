<?php
require_once __DIR__.'/includes/db.php';
require_once __DIR__.'/includes/auth.php';

if (current_user_id()) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username && $password) {
        $db = getDB();
        $stmt = $db->prepare('SELECT id, password_hash FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: index.php');
            exit;
        } else {
            $error = "Identifiants invalides";
        }
    } else {
        $error = "Tous les champs sont requis";
    }
}
require_once __DIR__.'/includes/header.php';
?>
<h1>Connexion</h1>
<?php if ($error): ?>
<div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<form method="post" class="mb-3">
    <div class="mb-3">
        <label class="form-label">Nom d'utilisateur</label>
        <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Mot de passe</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Se connecter</button>
    <a href="register.php" class="btn btn-link">Créer un compte</a>
</form>
<?php require_once __DIR__.'/includes/footer.php';
