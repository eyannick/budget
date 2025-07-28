<?php
require_once __DIR__.'/auth.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Budget perso</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
  <div class="container-fluid">
    <a class="navbar-brand" href="/budget/index.php">Budget</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="/budget/transactions/list.php">Transactions</a></li>
        <li class="nav-item"><a class="nav-link" href="/budget/categories/list.php">Catégories</a></li>
        <li class="nav-item"><a class="nav-link" href="/budget/subcategories/list.php">Sous-catégories</a></li>
        <li class="nav-item"><a class="nav-link" href="/budget/payment_modes/list.php">Modes de paiement</a></li>
        <li class="nav-item"><a class="nav-link" href="/budget/accounts/list.php">Comptes</a></li>
      </ul>
      <ul class="navbar-nav">
        <?php if (current_user_id()): ?>
            <li class="nav-item"><a class="nav-link" href="/logout.php">Se déconnecter</a></li>
        <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="/login.php">Se connecter</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container">