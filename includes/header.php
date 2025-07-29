<?php

  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }

  if (!isset($_SESSION["user_id"]) && basename($_SERVER["PHP_SELF"]) !== "login.php") {
      header("Location: ../login.php");
      exit;
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
        <a class="navbar-brand" href="/budget/index.php">Budgex - Gestion de budget personnel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <?php if (isset($_SESSION["user_id"])): ?>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto">
            <li class="nav-item"><a class="nav-link" href="/budget/controllers/add_account.php">Ajouter un compte</a></li>
            <li class="nav-item"><a class="nav-link" href="/budget/controllers/add_category.php">Ajouter une catégorie</a></li>
            <li class="nav-item"><a class="nav-link" href="/budget/controllers/list_categories.php">Liste des catégories</a></li>
          </ul>
          <span class="navbar-text text-white me-3"><?php echo $_SESSION["email"]; ?></span>
          <a href="/budget/logout.php" class="btn btn-outline-light btn-sm">Déconnexion</a>
        </div>
        <?php endif; ?>
      </div>
    </nav>

    <div class="container mt-4">
