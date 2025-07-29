
<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
requireLogin();

$selectedMonth = $_GET['month'] ?? date('Y-m');
$selectedType = $_GET['type'] ?? '';

$startDate = $selectedMonth . '-01';
$endDate = date('Y-m-t', strtotime($startDate));

$sql = "SELECT c.name AS category_label, sc.name AS subcategory_label, SUM(t.amount) AS total
        FROM transactions t
        JOIN categories c ON t.category_id = c.id
        LEFT JOIN categories sc ON t.subcategory_id = sc.id
        WHERE t.date BETWEEN :start AND :end";

$params = [':start' => $startDate, ':end' => $endDate];

if ($selectedType) {
    $sql .= " AND t.transaction_type = :type";
    $params[':type'] = $selectedType;
}

$sql .= " GROUP BY c.id, sc.id ORDER BY c.name, sc.name";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$chartData = [];
foreach ($results as $row) {
    $catLabel = $row['category_label'];
    $subcatLabel = $row['subcategory_label'] ?? 'Autre';

    if (!isset($chartData[$catLabel])) {
        $chartData[$catLabel] = ['total' => 0, 'subcategories' => []];
    }

    $chartData[$catLabel]['total'] += $row['total'];
    $chartData[$catLabel]['subcategories'][$subcatLabel] = ($chartData[$catLabel]['subcategories'][$subcatLabel] ?? 0) + $row['total'];
}

$flattenedData = [];
foreach ($chartData as $cat => $data) {
    $flattenedData[] = [
        'category' => $cat,
        'total' => $data['total'],
        'subcategories' => $data['subcategories']
    ];
}

include '../views/chart-view.php';
