<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

$user_id = $_SESSION['user_id'];

// Récupérer les données pour les filtres
$accounts = $pdo->prepare("SELECT id, name FROM accounts WHERE user_id = ?");
$accounts->execute([$user_id]);

$categories = $pdo->prepare("SELECT id, name FROM categories WHERE user_id = ? AND parent_id IS NULL");
$categories->execute([$user_id]);

$subcategories = $pdo->prepare("SELECT id, name FROM categories WHERE user_id = ? AND parent_id IS NOT NULL");
$subcategories->execute([$user_id]);

// Construire la requête filtrée
$query = "SELECT t.*, a.name AS account_name, c.name AS category_name, sc.name AS subcategory_name
          FROM transactions t
          JOIN accounts a ON t.account_id = a.id
          LEFT JOIN categories c ON t.category_id = c.id
          LEFT JOIN categories sc ON t.subcategory_id = sc.id
          WHERE t.user_id = :user_id";

$params = [':user_id' => $user_id];

if (!empty($_GET['start_date'])) {
    $query .= " AND t.date >= :start_date";
    $params[':start_date'] = $_GET['start_date'];
}
if (!empty($_GET['end_date'])) {
    $query .= " AND t.date <= :end_date";
    $params[':end_date'] = $_GET['end_date'];
}
if (!empty($_GET['account_id'])) {
    $query .= " AND t.account_id = :account_id";
    $params[':account_id'] = $_GET['account_id'];
}
if (!empty($_GET['category_id'])) {
    $query .= " AND t.category_id = :category_id";
    $params[':category_id'] = $_GET['category_id'];
}
if (!empty($_GET['subcategory_id'])) {
    $query .= " AND t.subcategory_id = :subcategory_id";
    $params[':subcategory_id'] = $_GET['subcategory_id'];
}
if (!empty($_GET['type'])) {
    $query .= " AND t.transaction_type = :type";
    $params[':type'] = $_GET['type'];
}
if (!empty($_GET['keyword'])) {
    $query .= " AND (t.label LIKE :keyword OR t.observation LIKE :keyword)";
    $params[':keyword'] = '%' . $_GET['keyword'] . '%';
}

$query .= " ORDER BY t.date DESC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$transactions = $stmt->fetchAll();

include '../views/list-transactions.php';
