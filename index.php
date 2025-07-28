<?php
require_once __DIR__.'/includes/auth.php';
require_login();
$db = getDB();
$year = date('Y');
$month = date('m');
$stmt = $db->prepare('SELECT type, SUM(amount) as total FROM transactions WHERE user_id=? AND YEAR(created_at)=? AND MONTH(created_at)=? GROUP BY type');
$stmt->execute([current_user_id(), $year, $month]);
$income = $expense = 0;
foreach ($stmt->fetchAll() as $row) {
    if ($row['type'] === 'income') {
        $income = $row['total'];
    } elseif ($row['type'] === 'expense') {
        $expense = $row['total'];
    }
}
$balance = $income - $expense;
require_once __DIR__.'/includes/header.php';
?>
<h1 class="mb-4">Tableau de bord</h1>
<p>Bienvenue sur votre application de suivi de budget.</p>
<p>Utilisez le menu pour gérer vos transactions et listes.</p>
<h2>Bilan du mois (<?= $month ?>/<?= $year ?>)</h2>
<table class="table">
  <tr><th>Revenus</th><td><?= htmlspecialchars($income) ?></td></tr>
  <tr><th>Dépenses</th><td><?= htmlspecialchars($expense) ?></td></tr>
  <tr><th>Solde</th><td><?= htmlspecialchars($balance) ?></td></tr>
</table>
<?php
require_once __DIR__.'/includes/footer.php';