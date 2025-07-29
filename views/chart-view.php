<?php include '../includes/header.php'; ?>

<div class="container mt-4">
  <div class="row justify-content-between align-items-center mb-3">
    <div class="col-md-6">
      <h2 class="mb-0">Dépenses par Catégorie</h2>
      <small class="text-muted">Visualisation du mois sélectionné</small>
    </div>
    <div class="col-md-6">
      <form method="get" class="row g-2 justify-content-end">
        <div class="col-auto">
          <input type="month" id="month" name="month" value="<?= htmlspecialchars($selectedMonth) ?>" class="form-control" onchange="this.form.submit()">
        </div>
        <div class="col-auto">
          <select name="type" class="form-select" onchange="this.form.submit()">
            <option value="">Tous</option>
            <option value="revenue" <?= $selectedType === 'revenue' ? 'selected' : '' ?>>Revenus</option>
            <option value="expense" <?= $selectedType === 'expense' ? 'selected' : '' ?>>Dépenses</option>
            <option value="transfer" <?= $selectedType === 'transfer' ? 'selected' : '' ?>>Virements</option>
          </select>
        </div>
      </form>
    </div>
  </div>

  <?php
  $totalMonth = 0;
  foreach ($chartData as $cat) {
    $totalMonth += $cat['total'];
  }
  ?>

  <div class="alert alert-primary text-center">
    Total <?= $selectedType ? $selectedType : 'des transactions' ?> pour <?= date('F Y', strtotime($selectedMonth . '-01')) ?> :
    <strong><?= number_format($totalMonth, 2, ',', ' ') ?> €</strong>
  </div>

  <div class="card mb-4 shadow-sm">
    <div class="card-body">
      <h5 class="card-title text-center">Répartition par Catégorie</h5>
      <canvas id="categoryChart" height="200"></canvas>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <h5 class="card-title text-center">Détail par Sous-catégorie</h5>
      <canvas id="subcategoryChart" height="150"></canvas>
    </div>
  </div>
</div>

<!-- Chart.js et script personnalisé -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  window.chartData = <?= json_encode($flattenedData) ?>;
</script>
<script src="../includes/js/chart-categories.js"></script>

<?php include '../includes/footer.php'; ?>
