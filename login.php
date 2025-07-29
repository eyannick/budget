<?php
  session_start();
  require_once 'includes/db.php';

  $error = "";

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $email = trim($_POST["email"]);
      $password = $_POST["password"];

      $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
      $stmt->execute([$email]);
      $user = $stmt->fetch();

      if ($user && password_verify($password, $user["password"])) {
          $_SESSION["user_id"] = $user["id"];
          $_SESSION["email"] = $user["email"];
          header("Location: index.php");
          exit;
      } else {
          $error = "Identifiants incorrects.";
      }
  }
?>

<?php include 'includes/header.php'; ?>

  <div class="container mt-5" style="max-width: 400px;">

    <h2>Connexion</h2>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post">
      <div class="mb-3">
        <label for="email" class="form-label">Adresse e-mail</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>

    <p class="mt-3">Pas encore inscrit ? <a href="register.php">Créer un compte</a></p>
    
  </div>

<?php include 'includes/footer.php'; ?>
