<?php
require_once __DIR__.'/../includes/auth.php';
require_login();
$db = getDB();

if (isset($_POST['delete'])) {
    $stmt = $db->prepare('DELETE FROM transactions WHERE id=? AND user_id=?');
    $stmt->execute([$_POST['delete'], current_user_id()]);
}

$year = $_GET['year'] ?? date('Y');
$month = $_GET['month'] ?? '';
$params = [current_user_id()];
$sql = 'SELECT t.id, t.amount, t.type, t.created_at, c.name AS category, s.name AS subcategory, a.name AS account, pm.name AS payment_mode, t.label
        FROM transactions t
        LEFT JOIN categories c ON t.category_id=c.id
        LEFT JOIN subcategories s ON t.subcategory_id=s.id
        JOIN accounts a ON t.account_id=a.id
        LEFT JOIN payment_modes pm ON t.payment_mode_id=pm.id
        WHERE t.user_id=?';
if ($year) {
    $sql .= ' AND YEAR(t.created_at)=?';
    $params[] = $year;
    if ($month) {
        $sql .= ' AND MONTH(t.created_at)=?';
        $params[] = $month;
    }
}
$sql .= ' ORDER BY t.created_at DESC';
$stmt = $db->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();

// Totaux par catégorie pour la période
$totSql = 'SELECT c.name AS category, SUM(t.amount) as total
           FROM transactions t JOIN categories c ON t.category_id=c.id
           WHERE t.user_id=? AND YEAR(t.created_at)=?';
$totParams = [current_user_id(), $year];
if ($month) {
    $totSql .= ' AND MONTH(t.created_at)=?';
    $totParams[] = $month;
}
$totSql .= ' GROUP BY c.name ORDER BY c.name';
$totStmt = $db->prepare($totSql);
$totStmt->execute($totParams);
$totals = $totStmt->fetchAll();

require_once __DIR__.'/../includes/header.php';
?>
<h1>Transactions</h1>
<a href="add.php" class="btn btn-primary mb-3">Ajouter</a>
<form method="get" class="row g-3 mb-3">
  <div class="col-auto">
    <select name="year" class="form-select">
      <?php $y=date('Y'); for($i=$y-5;$i<=$y;$i++): ?>
      <option value="<?= $i ?>"<?= $i==$year?' selected':'' ?>><?= $i ?></option>
      <?php endfor; ?>
    </select>
  </div>
  <div class="col-auto">
    <select name="month" class="form-select">
      <option value="">Tous les mois</option>
      <?php for($m=1;$m<=12;$m++): ?>
      <option value="<?= $m ?>"<?= $m==$month?' selected':'' ?>><?= $m ?></option>
      <?php endfor; ?>
    </select>
  </div>
  <div class="col-auto">
    <button type="submit" class="btn btn-secondary">Filtrer</button>
  </div>
</form>
<table class="table table-striped">
  <tr>
    <th>Date</th><th>Type</th><th>Montant</th><th>Compte</th><th>Catégorie</th><th>Sous-catégorie</th><th>Mode</th><th>Libellé</th><th>Actions</th>
  </tr>
  <?php foreach ($rows as $row): ?>
  <tr>
    <td><?= htmlspecialchars($row['created_at']) ?></td>
    <td><?= htmlspecialchars($row['type']) ?></td>
    <td><?= htmlspecialchars($row['amount']) ?></td>
    <td><?= htmlspecialchars($row['account']) ?></td>
    <td><?= htmlspecialchars($row['category']) ?></td>
    <td><?= htmlspecialchars($row['subcategory']) ?></td>
    <td><?= htmlspecialchars($row['payment_mode']) ?></td>
    <td><?= htmlspecialchars($row['label']) ?></td>
    <td>
      <a class="btn btn-sm btn-secondary" href="edit.php?id=<?= $row['id'] ?>">Éditer</a>
      <form method="post" class="d-inline" onsubmit="return confirm('Supprimer ?');">
        <input type="hidden" name="delete" value="<?= $row['id'] ?>">
        <button class="btn btn-sm btn-danger">Supprimer</button>
      </form>
    </td>
  </tr>
  <?php endforeach; ?>
</table>
<h2>Totaux par catégorie (<?= $year ?><?= $month?'/'.$month:'' ?>)</h2>
<table class="table">
<tr><th>Catégorie</th><th>Total</th></tr>
<?php foreach($totals as $t): ?>
<tr><td><?= htmlspecialchars($t['category']) ?></td><td><?= htmlspecialchars($t['total']) ?></td></tr>
<?php endforeach; ?>
</table>
<?php require_once __DIR__.'/../includes/footer.php';
