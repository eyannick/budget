<?php
<<<<<<< HEAD
require_once dirname(__DIR__).'/includes/auth.php';
=======
require_once __DIR__.'/../includes/auth.php';
>>>>>>> 56ad122dbfc9a25313c64344091314310913a7af
require_login();
$db = getDB();
$id = (int)($_GET['id'] ?? 0);
$stmt = $db->prepare('SELECT * FROM transactions WHERE id=? AND user_id=?');
$stmt->execute([$id, current_user_id()]);
$trans = $stmt->fetch();
if (!$trans) { header('Location: list.php'); exit; }

$accounts = $db->prepare('SELECT id, name FROM accounts WHERE user_id=? ORDER BY name');
$accounts->execute([current_user_id()]);
$accounts = $accounts->fetchAll();
$categories = $db->prepare('SELECT id, name FROM categories WHERE user_id=? ORDER BY name');
$categories->execute([current_user_id()]);
$categories = $categories->fetchAll();
$payment_modes = $db->prepare('SELECT id, name FROM payment_modes WHERE user_id=? ORDER BY name');
$payment_modes->execute([current_user_id()]);
$payment_modes = $payment_modes->fetchAll();

<<<<<<< HEAD
// subcategories with category name
$subcategoriesStmt = $db->prepare(
    'SELECT s.id, CONCAT(c.name, " - ", s.name) AS name
     FROM subcategories s
     JOIN categories c ON s.category_id = c.id
     WHERE c.user_id = ?
     ORDER BY c.name, s.name'
);
$subcategoriesStmt->execute([current_user_id()]);
$subcategories = $subcategoriesStmt->fetchAll();

=======
>>>>>>> 56ad122dbfc9a25313c64344091314310913a7af
$error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $account_id = (int)($_POST['account_id'] ?? 0);
    $amount = $_POST['amount'] ?? '';
    $type = $_POST['type'] ?? '';
    $category_id = (int)($_POST['category_id'] ?? 0);
    $subcategory_id = (int)($_POST['subcategory_id'] ?? 0) ?: null;
    $payment_mode_id = (int)($_POST['payment_mode_id'] ?? 0) ?: null;
    $label = trim($_POST['label'] ?? '');
    $notes = trim($_POST['notes'] ?? '');
    $date = $_POST['created_at'] ?? date('Y-m-d');
<<<<<<< HEAD
 $validType = in_array($type, ['income', 'expense'], true);
    if ($account_id > 0 && $amount !== '' && $validType && $category_id > 0) {
=======
    if ($account_id && $amount !== '' && $type && $category_id) {
>>>>>>> 56ad122dbfc9a25313c64344091314310913a7af
        $stmt = $db->prepare('UPDATE transactions SET account_id=?, amount=?, type=?, category_id=?, subcategory_id=?, payment_mode_id=?, label=?, notes=?, created_at=? WHERE id=? AND user_id=?');
        $stmt->execute([$account_id,$amount,$type,$category_id,$subcategory_id,$payment_mode_id,$label,$notes,$date,$id,current_user_id()]);
        header('Location: list.php');
        exit;
    } else {
        $error='Champs requis manquants';
    }
}
<<<<<<< HEAD
require_once dirname(__DIR__).'/includes/header.php';
?>
<h1>Éditer la transaction</h1>
<?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post" action="edit.php?id=<?= $id ?>">
=======
require_once __DIR__.'/../includes/header.php';
?>
<h1>Éditer la transaction</h1>
<?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post">
<div class="row">
  <div class="col-md-4 mb-3">
    <label class="form-label">Compte</label>
    <select name="account_id" class="form-select" required>
      <?php foreach($accounts as $a): ?>
      <option value="<?= $a['id'] ?>"<?= $a['id']==$trans['account_id']?' selected':'' ?>><?= htmlspecialchars($a['name']) ?></option>
      <?php endforeach; ?>
>>>>>>> 56ad122dbfc9a25313c64344091314310913a7af
    </select>
  </div>
  <div class="col-md-4 mb-3">
    <label class="form-label">Type</label>
    <select name="type" class="form-select" required>
      <option value="income"<?= $trans['type']=='income'?' selected':'' ?>>Revenu</option>
      <option value="expense"<?= $trans['type']=='expense'?' selected':'' ?>>Dépense</option>
    </select>
  </div>
  <div class="col-md-4 mb-3">
    <label class="form-label">Montant</label>
    <input type="number" step="0.01" name="amount" value="<?= htmlspecialchars($trans['amount']) ?>" class="form-control" required>
  </div>
</div>
<div class="row">
  <div class="col-md-4 mb-3">
    <label class="form-label">Catégorie</label>
    <select name="category_id" class="form-select" required>
      <?php foreach($categories as $c): ?>
      <option value="<?= $c['id'] ?>"<?= $c['id']==$trans['category_id']?' selected':'' ?>><?= htmlspecialchars($c['name']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-4 mb-3">
    <label class="form-label">Sous-catégorie</label>
<<<<<<< HEAD
    <select name="subcategory_id" class="form-select">
      <option value="">---</option>
      <?php foreach ($subcategories as $sc): ?>
      <option value="<?= $sc['id'] ?>"<?= $sc['id']==($trans['subcategory_id'] ?? 0)?' selected':'' ?>><?= htmlspecialchars($sc['name']) ?></option>
      <?php endforeach; ?>
    </select>
=======
    <input type="number" name="subcategory_id" value="<?= htmlspecialchars($trans['subcategory_id']) ?>" class="form-control">
>>>>>>> 56ad122dbfc9a25313c64344091314310913a7af
  </div>
  <div class="col-md-4 mb-3">
    <label class="form-label">Mode de paiement</label>
    <select name="payment_mode_id" class="form-select">
      <option value="">---</option>
      <?php foreach($payment_modes as $pm): ?>
      <option value="<?= $pm['id'] ?>"<?= $pm['id']==$trans['payment_mode_id']?' selected':'' ?>><?= htmlspecialchars($pm['name']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
</div>
<div class="mb-3">
  <label class="form-label">Date</label>
<<<<<<< HEAD
  <input type="date" name="created_at" value="<?= htmlspecialchars($trans['created_at']) ?>" class="form-control">
</div>
<div class="mb-3">
  <label class="form-label">Libellé</label>
  <input type="text" name="label" value="<?= htmlspecialchars($trans['label'] ?? '') ?>" class="form-control">
</div>
<div class="mb-3">
  <label class="form-label">Observation</label>
  <textarea name="notes" class="form-control"><?= htmlspecialchars($trans['notes'] ?? '') ?></textarea>
</div>
<button type="submit" class="btn btn-primary">Enregistrer</button>
<a href="list.php" class="btn btn-secondary">Retour</a>
=======
  <input type="date" name="created_at" value="<?= $trans['created_at'] ?>" class="form-control">
</div>
<div class="mb-3">
  <label class="form-label">Libellé</label>
  <input type="text" name="label" value="<?= htmlspecialchars($trans['label']) ?>" class="form-control">
</div>
<div class="mb-3">
  <label class="form-label">Observation</label>
  <textarea name="notes" class="form-control"><?= htmlspecialchars($trans['notes']) ?></textarea>
</div>
<button type="submit" class="btn btn-primary">Enregistrer</button>
<a href="list.php" class="btn btn-secondary">Retour</a>
</form>
<?php require_once __DIR__.'/../includes/footer.php';
>>>>>>> 56ad122dbfc9a25313c64344091314310913a7af
