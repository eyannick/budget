<?php
  require_once __DIR__ . '/../includes/header.php';
  require_once __DIR__ . '/../includes/db.php';

  // Récupération des comptes de l'utilisateur
  $stmt = $pdo->prepare("SELECT id, name FROM accounts WHERE user_id = ?");
  $stmt->execute([$_SESSION["user_id"]]);
  $accounts = $stmt->fetchAll();

  // Récupération des catégories
  $stmt = $pdo->prepare("SELECT id, name FROM categories WHERE user_id = ?");
  $stmt->execute([$_SESSION["user_id"]]);
  $categories = $stmt->fetchAll();

  // Récupération des sous-catégories
  $stmt = $pdo->prepare("SELECT id, name, category_id FROM subcategories WHERE user_id = ?");
  $stmt->execute([$_SESSION["user_id"]]);
  $subcategories = $stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_UNIQUE);

?>

<div class="container mt-4" style="max-width: 700px;">
  <h2>Nouvelle transaction</h2>
  <form method="post" action="/budget/controllers/add_transaction.php">
    <div class="mb-3">
      <label for="transaction_type" class="form-label">Type de transaction</label>
      <select name="transaction_type" id="transaction_type" class="form-select" required onchange="toggleVirementFields()">
        <option value="">-- Sélectionner --</option>
        <option value="revenu">Revenu</option>
        <option value="dépense">Dépense</option>
        <option value="virement">Virement</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="account_id" class="form-label">Compte source</label>
      <select name="account_id" id="account_id" class="form-select" required>
        <option value="">-- Sélectionner un compte --</option>
        <?php foreach ($accounts as $account): ?>
          <option value="<?php echo $account['id']; ?>"><?php echo htmlspecialchars($account['name']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3" id="target_account_group" style="display: none;">
      <label for="target_account_id" class="form-label">Compte cible (si virement)</label>
      <select name="target_account_id" id="target_account_id" class="form-select">
        <option value="">-- Sélectionner un compte --</option>
        <?php foreach ($accounts as $account): ?>
          <option value="<?php echo $account['id']; ?>"><?php echo htmlspecialchars($account['name']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="amount" class="form-label">Montant (€)</label>
      <input type="number" step="0.01" min="0" class="form-control" name="amount" required>
    </div>

    <div class="mb-3">
      <label for="date" class="form-label">Date</label>
      <input type="date" class="form-control" name="date" required>
    </div>

    <div class="mb-3">
      <label for="category_id" class="form-label">Catégorie</label>
      <select name="category_id" id="category_id" class="form-select">
        <option value="">-- Sélectionner une catégorie --</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="subcategory_id" class="form-label">Sous-catégorie</label>
      <select name="subcategory_id" id="subcategory_id" class="form-select">
        <option value="">-- Sélectionner une sous-catégorie --</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="label" class="form-label">Libellé</label>
      <input type="text" class="form-control" name="label">
    </div>

    <div class="mb-3">
      <label for="observation" class="form-label">Observation</label>
      <textarea name="observation" class="form-control" rows="3"></textarea>
    </div>

    <button type="submit" class="btn btn-success">Enregistrer</button>
  </form>
</div>

<script>
  const allSubcategories = <?php
      $subs = [];
      foreach ($subcategories as $id => $data) {
          $subs[] = ['id' => $id, 'name' => $data['name'], 'category_id' => $data['category_id']];
      }
      echo json_encode($subs);
  ?>;

  const categorySelect = document.getElementById("category_id");
  const subcategorySelect = document.getElementById("subcategory_id");

  categorySelect.addEventListener("change", () => {
      const selectedCatId = categorySelect.value;
      subcategorySelect.innerHTML = '<option value="">-- Sélectionner une sous-catégorie --</option>';

      allSubcategories.forEach(sub => {
          if (sub.category_id === selectedCatId) {
              const option = document.createElement("option");
              option.value = sub.id;
              option.textContent = sub.name;
              subcategorySelect.appendChild(option);
          }
      });
  });

  function toggleVirementFields() {
    const type = document.getElementById('transaction_type').value;
    const targetGroup = document.getElementById('target_account_group');
    targetGroup.style.display = (type === 'virement') ? 'block' : 'none';
  }
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
