<?php
    require_once '../includes/db.php';
    include '../includes/header.php';

    $message = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $name = trim($_POST["name"]);
        $balance = floatval(str_replace(',', '.', $_POST["balance"]));

        if (empty($name)) {
            $message = "Le nom du compte est requis.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO accounts (user_id, name, balance) VALUES (?, ?, ?)");
            $stmt->execute([$_SESSION["user_id"], $name, $balance]);
            $message = "Compte ajouté avec succès.";
        }
    }

    include '../views/add_account_form.php';
    include '../includes/footer.php';
