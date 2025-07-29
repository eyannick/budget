<?php
  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }

  $public_pages = ['login.php', 'register.php'];
  $current_page = basename($_SERVER['PHP_SELF']);
  if (!in_array($current_page, $public_pages) && !isset($_SESSION["user_id"])) {
      header("Location: login.php");
      exit;
  }

  // Récupération des infos utilisateur si connecté
  $user_fullname = '';
  if (isset($_SESSION["user_id"])) {
      require_once 'db.php';
      $stmt = $pdo->prepare("SELECT first_name, last_name FROM users WHERE id = ?");
      $stmt->execute([$_SESSION["user_id"]]);
      $user = $stmt->fetch();
      if ($user) {
          $user_fullname = htmlspecialchars($user["first_name"] . ' ' . $user["last_name"]);
      }
  }
?>


<!DOCTYPE html>
<html lang="fr">

  <head>
    <meta charset="UTF-8">
    <title>Budgex - Gestion de budget personnel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/budget/includes/css/style.css" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

      <div class="container-fluid">
        <a class="navbar-brand" href="/budget/index.php">Budgex</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>

        <?php if (isset($_SESSION["user_id"])): ?>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link" href="/budget/index.php">Tableau de bord</a></li>
            <li class="nav-item"><a class="nav-link" href="/budget/controllers/add_transaction.php">Ajouter une transaction</a></li>
            <li class="nav-item"><a class="nav-link" href="/budget/controllers/add_account.php">Ajouter un compte</a></li>
            <li class="nav-item"><a class="nav-link" href="/budget/controllers/add_category.php">Ajouter une catégorie</a></li>
            <li class="nav-item"><a class="nav-link" href="/budget/controllers/add_subcategory.php">Ajouter une sous-catégorie</a></li>
            <li class="nav-item"><a class="nav-link" href="/budget/controllers/list_transactions.php">Historique</a></li>
          </ul>
          <span class="navbar-text me-2">Bonjour, <?php echo $user_fullname; ?></span>
          <a href="/budget/logout.php" class="btn btn-outline-light btn-sm">Déconnexion</a>
        </div>

        <?php else: ?>

        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link" href="/budget/login.php">Connexion</a></li>
            <li class="nav-item"><a class="nav-link" href="/budget/register.php">Inscription</a></li>
          </ul>
        </div>
        
        <?php endif; ?>
      </div>

    </nav>  

    <div class="container mt-4">