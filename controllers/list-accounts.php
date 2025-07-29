<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT a.id, a.name, a.initial_balance
    FROM accounts a
    WHERE a.user_id = :user_id
");
$stmt->execute(['user_id' => $user_id]);
$accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($accounts as &$account) {
    $stmt = $pdo->prepare("
        SELECT t.amount, t.transaction_type, c.name AS category, s.name AS subcategory, t.label, t.date, t.observation
        FROM transactions t
        LEFT JOIN categories c ON t.category_id = c.id
        LEFT JOIN categories s ON t.subcategory_id = s.id
        WHERE t.account_id = :account_id AND t.user_id = :user_id
        ORDER BY t.date DESC
    ");
    $stmt->execute(['account_id' => $account['id'], 'user_id' => $user_id]);
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $balance = $account['initial_balance'];
    foreach ($transactions as $txn) {
        if ($txn['transaction_type'] === 'revenue') {
            $balance += $txn['amount'];
        } elseif ($txn['transaction_type'] === 'expense' || $txn['transaction_type'] === 'transfer') {
            $balance -= $txn['amount'];
        }
    }

    $account['transactions'] = $transactions;
    $account['balance'] = $balance;
}
unset($account);

include '../views/list-accounts.php';
?>
