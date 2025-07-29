<?php

  require_once 'includes/db.php';

  session_start();

  if (isset($_SESSION["user_id"])) {
      header("Location: index.php");
      exit;
  }
  
  $errors = [];

  if ($_SERVER["REQUEST_METHOD"] === "POST") {

      $first_name = trim($_POST["first_name"]);
      $last_name = trim($_POST["last_name"]);
      $email = trim($_POST["email"]);
      $password = $_POST["password"];
      $confirm_password = $_POST["confirm_password"];

      if (empty($first_name) || empty($last_name)) {
          $errors[] = "Le prénom et le nom sont obligatoires.";
      }

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $errors[] = "Adresse email invalide.";
      }

      if ($password !== $confirm_password) {
          $errors[] = "Les mots de passe ne correspondent pas.";
      }

      if (empty($errors)) {
          $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

          $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
          try {
              $stmt->execute([$first_name, $last_name, $email, $hashedPassword]);
              header("Location: login.php");
              exit;
          } catch (PDOException $e) {
              if ($e->getCode() == 23000) {
                  $errors[] = "Un compte avec cet email existe déjà.";
              } else {
                  $errors[] = "Erreur lors de l'inscription : " . $e->getMessage();
              }
          }
      }
  }
?>

<?php include 'includes/header.php'; ?>

  <div class="container mt-5" style="max-width: 500px;">

    <h2>Créer un compte</h2>

    <?php if ($errors): ?>
      <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
          <div><?php echo htmlspecialchars($error); ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form method="post">

      <div class="mb-3">
        <label for="first_name" class="form-label">Prénom</label>
        <input type="text" class="form-control" id="first_name" name="first_name" required>
      </div>

      <div class="mb-3">
        <label for="last_name" class="form-label">Nom</label>
        <input type="text" class="form-control" id="last_name" name="last_name" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Adresse e-mail</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>

      <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
      </div>
      <button type="submit" class="btn btn-primary">S'inscrire</button>

    </form>

  </div>

<?php include 'includes/footer.php'; ?>
