<?php include '../includes/header.php'; ?>

  <div class="container mt-5">
    <h2>Ajouter une transaction</h2>

    <?php if (!empty($message)) : ?>
      <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" action="../controllers/add_transaction.php">
      <div class="row">
        <div class="col-md-4 mb-3">
          <label for="transaction_type" class="form-label">Type de transaction</label>
          <select name="transaction_type" id="transaction_type" class="form-select" required>
            <option value="">-- Sélectionner --</option>
            <option value="revenu">Revenu</option>
            <option value="dépense">Dépense</option>
            <option value="virement">Virement</option>
          </select>
        </div>

        <div class="col-md-4 mb-3">
          <label for="amount" class="form-label">Montant (€)</label>
          <input type="number" name="amount" step="0.01" class="form-control" required>
        </div>

        <div class="col-md-4 mb-3">
          <label for="date" class="form-label">Date</label>
          <input type="date" name="date" class="form-control" value="<?= date('Y-m-d') ?>" required>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="account_id" class="form-label">Compte source</label>
          <select name="account_id" class="form-select" required>
            <option value="">-- Sélectionner un compte --</option>
            <?php foreach ($accounts as $a) : ?>
              <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-6 mb-3" id="target_account_group" style="display:none;">
          <label for="target_account_id" class="form-label">Compte cible</label>
          <select name="target_account_id" class="form-select">
            <option value="">-- Sélectionner un compte --</option>
            <?php foreach ($accounts as $a) : ?>
              <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="category_id" class="form-label">Catégorie</label>
          <select name="category_id" id="category_id" class="form-select">
            <option value="">-- Sélectionner une catégorie --</option>
            <?php foreach ($categories as $c) : ?>
              <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-6 mb-3">
          <label for="subcategory_id" class="form-label">Sous-catégorie</label>
          <select name="subcategory_id" id="subcategory_id" class="form-select">
            <option value="">-- Sélectionner une sous-catégorie --</option>
          </select>
        </div>
      </div>

      <div class="mb-3">
        <label for="label" class="form-label">Libellé</label>
        <input type="text" name="label" class="form-control">
      </div>

      <div class="mb-3">
        <label for="observation" class="form-label">Observation</label>
        <textarea name="observation" class="form-control" rows="3"></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
  </div>

  <script>
    window.allSubcategories = <?= json_encode($allSubcategories, JSON_HEX_TAG) ?>;
  </script>

  <script src="../includes/js/script.js"></script>

<?php include '../includes/footer.php'; ?>