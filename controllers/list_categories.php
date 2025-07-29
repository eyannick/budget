<?php
    require_once '../includes/db.php';
    include '../includes/header.php';

    $stmt = $pdo->prepare("SELECT * FROM categories WHERE user_id = ? ORDER BY parent_id IS NOT NULL, parent_id, name");
    $stmt->execute([$_SESSION["user_id"]]);
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    include '../views/list_categories.php';
    include '../includes/footer.php';
