<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "
SELECT 
    t.id, t.date, t.transaction_type, t.amount, t.label, t.observation,
    a.name AS account_name,
    ta.name AS target_account_name,
    c.name AS category_name,
    sc.name AS subcategory_name
FROM transactions t
LEFT JOIN accounts a ON t.account_id = a.id
LEFT JOIN accounts ta ON t.target_account_id = ta.id
LEFT JOIN categories c ON t.category_id = c.id
LEFT JOIN subcategories sc ON t.subcategory_id = sc.id
WHERE t.user_id = :user_id
ORDER BY t.date DESC
";

$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $user_id]);
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../views/list-transactions.php';
?>
