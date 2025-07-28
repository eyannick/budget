<?php
  session_start();
  require_once 'includes/db.php';

  $message = "";

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
      $password = $_POST["password"];

      $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = ?");
      $stmt->execute([$email]);
      $user = $stmt->fetch();

      if ($user && password_verify($password, $user["password"])) {
          $_SESSION["user_id"] = $user["id"];
          header("Location: index.php");
          exit;
      } else {
          $message = "Identifiants incorrects.";
      }
  }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <h2 class="mb-4">Connexion</h2>

  <?php if ($message): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($message); ?></div>
  <?php endif; ?>

  <form method="post" class="row g-3">
    <div class="col-md-6">
      <label for="email" class="form-label">Adresse email</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="col-md-6">
      <label for="password" class="form-label">Mot de passe</label>
      <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary">Se connecter</button>
    </div>
  </form>
</div>
</body>
</html>