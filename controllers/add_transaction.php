<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION["user_id"];
    $type = $_POST["transaction_type"] ?? '';
    $account_id = $_POST["account_id"] ?? null;
    $amount = $_POST["amount"] ?? 0;
    $date = $_POST["date"] ?? date('Y-m-d');
    $category_id = $_POST["category_id"] ?: null;
    $subcategory_id = $_POST["subcategory_id"] ?: null;
    $label = trim($_POST["label"] ?? '');
    $observation = trim($_POST["observation"] ?? '');
    $target_account_id = $_POST["target_account_id"] ?? null;

    if ($type === 'virement') {
        // Insère le débit
        $stmt = $pdo->prepare("INSERT INTO transactions 
            (user_id, account_id, transaction_type, amount, date, category_id, subcategory_id, label, observation, target_account_id) 
            VALUES (?, ?, 'virement', ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $account_id, -abs($amount), $date, $category_id, $subcategory_id, $label, $observation, $target_account_id]);

        // Insère le crédit dans le compte cible
        $stmt = $pdo->prepare("INSERT INTO transactions 
            (user_id, account_id, transaction_type, amount, date, category_id, subcategory_id, label, observation) 
            VALUES (?, ?, 'virement', ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $target_account_id, abs($amount), $date, $category_id, $subcategory_id, $label, $observation]);

    } else {
        // revenu ou dépense
        if ($type === 'dépense') {
            $amount = -abs($amount);
        }

        $stmt = $pdo->prepare("INSERT INTO transactions 
            (user_id, account_id, transaction_type, amount, date, category_id, subcategory_id, label, observation) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $account_id, $type, $amount, $date, $category_id, $subcategory_id, $label, $observation]);
    }

    header("Location: ../views/add_transaction_form.php?success=1");
    exit;
} else {
    header("Location: ../views/add_transaction_form.php");
    exit;
}
?>
