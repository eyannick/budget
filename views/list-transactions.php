<?php include '../includes/header.php'; ?>
<div class="container mt-4">
  <h2 class="mb-4">Filtrer les Transactions</h2>
  <form method="get" class="row g-3 mb-4">
    <div class="col-md-3">
      <label for="start_date" class="form-label">Date de début</label>
      <input type="date" class="form-control" name="start_date" value="<?= htmlspecialchars($_GET['start_date'] ?? '') ?>">
    </div>
    <div class="col-md-3">
      <label for="end_date" class="form-label">Date de fin</label>
      <input type="date" class="form-control" name="end_date" value="<?= htmlspecialchars($_GET['end_date'] ?? '') ?>">
    </div>
    <div class="col-md-3">
      <label for="account_id" class="form-label">Compte</label>
      <select name="account_id" class="form-select">
        <option value="">Tous</option>
        <?php foreach ($accounts as $account): ?>
          <option value="<?= $account['id'] ?>" <?= ($_GET['account_id'] ?? '') == $account['id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($account['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-3">
      <label for="type" class="form-label">Type</label>
      <select name="type" class="form-select">
        <option value="">Tous</option>
        <option value="revenue" <?= ($_GET['type'] ?? '') === 'revenue' ? 'selected' : '' ?>>Revenu</option>
        <option value="expense" <?= ($_GET['type'] ?? '') === 'expense' ? 'selected' : '' ?>>Dépense</option>
        <option value="transfer" <?= ($_GET['type'] ?? '') === 'transfer' ? 'selected' : '' ?>>Virement</option>
      </select>
    </div>
    <div class="col-md-3">
      <label for="category_id" class="form-label">Catégorie</label>
      <select name="category_id" class="form-select">
        <option value="">Toutes</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= $cat['id'] ?>" <?= ($_GET['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($cat['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-3">
      <label for="subcategory_id" class="form-label">Sous-catégorie</label>
      <select name="subcategory_id" class="form-select">
        <option value="">Toutes</option>
        <?php foreach ($subcategories as $sub): ?>
          <option value="<?= $sub['id'] ?>" <?= ($_GET['subcategory_id'] ?? '') == $sub['id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($sub['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-3">
      <label for="keyword" class="form-label">Mot-clé</label>
      <input type="text" class="form-control" name="keyword" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
    </div>
    <div class="col-md-3 align-self-end">
      <button type="submit" class="btn btn-primary w-100">Filtrer</button>
    </div>
  </form>

  <h4>Résultats</h4>
  <div class="table-responsive">
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Date</th>
          <th>Compte</th>
          <th>Catégorie</th>
          <th>Sous-catégorie</th>
          <th>Libellé</th>
          <th>Montant</th>
          <th>Type</th>
          <th>Observations</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($transactions)): ?>
          <tr><td colspan="8" class="text-center">Aucune transaction trouvée.</td></tr>
        <?php else: ?>
          <?php foreach ($transactions as $t): ?>
            <tr>
              <td><?= htmlspecialchars($t['date']) ?></td>
              <td><?= htmlspecialchars($t['account_name']) ?></td>
              <td><?= htmlspecialchars($t['category_name'] ?? '') ?></td>
              <td><?= htmlspecialchars($t['subcategory_name'] ?? '') ?></td>
              <td><?= htmlspecialchars($t['label']) ?></td>
              <td><?= number_format($t['amount'], 2, ',', ' ') ?> €</td>
              <td><?= htmlspecialchars($t['transaction_type']) ?></td>
              <td><?= htmlspecialchars($t['observation']) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include '../includes/footer.php'; ?>
