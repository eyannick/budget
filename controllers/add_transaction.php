<?php
    session_start();
    require_once '../includes/db.php';

    if (!isset($_SESSION['user_id'])) {
        header('Location: ../login.php');
        exit;
    }

    $message = '';

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $user_id = $_SESSION['user_id'];
        $account_id = $_POST['account_id'];
        $transaction_type = $_POST['transaction_type'];
        $amount = str_replace(',', '.', $_POST['amount']);
        $date = $_POST['date'];
        $category_id = !empty($_POST['category_id']) ? $_POST['category_id'] : null;
        $subcategory_id = !empty($_POST['subcategory_id']) ? $_POST['subcategory_id'] : null;
        $label = $_POST['label'] ?? null;
        $observation = $_POST['observation'] ?? null;
        $target_account_id = $transaction_type === 'virement' ? $_POST['target_account_id'] : null;

        $sql = "INSERT INTO transactions (user_id, account_id, transaction_type, amount, date, category_id, subcategory_id, label, observation, target_account_id)
                VALUES (:user_id, :account_id, :transaction_type, :amount, :date, :category_id, :subcategory_id, :label, :observation, :target_account_id)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'user_id' => $user_id,
            'account_id' => $account_id,
            'transaction_type' => $transaction_type,
            'amount' => $amount,
            'date' => $date,
            'category_id' => $category_id,
            'subcategory_id' => $subcategory_id,
            'label' => $label,
            'observation' => $observation,
            'target_account_id' => $target_account_id
        ]);

        $message = "Transaction enregistrée avec succès.";
    }

    // Récupérer les comptes
    $stmt = $pdo->prepare("SELECT id, name FROM accounts WHERE user_id = ?");
    $stmt->execute([$_SESSION["user_id"]]);
    $accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer les catégories
    $stmt = $pdo->prepare("SELECT id, name FROM categories WHERE user_id = ?");
    $stmt->execute([$_SESSION["user_id"]]);
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer toutes les sous-catégories
    $stmt = $pdo->prepare("SELECT id, name, category_id FROM subcategories WHERE user_id = ?");
    $stmt->execute([$_SESSION["user_id"]]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $allSubcategories = [];
    foreach ($rows as $row) {
        $allSubcategories[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'category_id' => $row['category_id']
        ];
    }

include '../views/add_transaction_form.php';
