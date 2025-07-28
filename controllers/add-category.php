<?php
require_once '../includes/db.php';
include '../includes/header.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $parent_id = isset($_POST["parent_id"]) && $_POST["parent_id"] !== '' ? intval($_POST["parent_id"]) : null;

    if (empty($name)) {
        $message = "Le nom est requis.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO categories (user_id, name, parent_id) VALUES (?, ?, ?)");
        $stmt->execute([$_SESSION["user_id"], $name, $parent_id]);
        $message = "Catégorie ajoutée avec succès.";
    }
}

$categories = $pdo->prepare("SELECT id, name FROM categories WHERE user_id = ? AND parent_id IS NULL");
$categories->execute([$_SESSION["user_id"]]);
$parentCategories = $categories->fetchAll();

include '../views/add_category_form.php';
include '../includes/footer.php';
