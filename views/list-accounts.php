<?php include '../includes/header.php'; ?>

<div class="container mt-4">
  <h2 class="mb-4">Liste des Comptes</h2>

  <?php foreach ($accounts as $account): ?>
    <div class="card mb-3">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><?= htmlspecialchars($account['name']) ?></h5>
        <span class="fw-bold">
          Solde : 
          <span class="<?= $account['balance'] >= 0 ? 'text-success' : 'text-danger' ?>">
            <?= $account['balance'] >= 0 ? '+' : '-' ?>
            <?= number_format(abs($account['balance']), 2, ',', ' ') ?> €
          </span>
        </span>
      </div>
      <div class="card-body">
        <?php if (empty($account['transactions'])): ?>
          <p class="text-muted">Aucune transaction enregistrée.</p>
        <?php else: ?>
          <div class="accordion" id="accordion-<?= $account['id'] ?>">
            <div class="accordion-item">
              <h2 class="accordion-header" id="heading-<?= $account['id'] ?>">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $account['id'] ?>" aria-expanded="false" aria-controls="collapse-<?= $account['id'] ?>">
                  Voir les transactions
                </button>
              </h2>
              <div id="collapse-<?= $account['id'] ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?= $account['id'] ?>" data-bs-parent="#accordion-<?= $account['id'] ?>">
                <div class="accordion-body">
                  <table class="table table-sm table-hover">
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th>Catégorie</th>
                        <th>Sous-catégorie</th>
                        <th>Libellé</th>
                        <th>Montant</th>
                        <th>Observation</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($account['transactions'] as $txn): ?>
                        <tr>
                          <td><?= htmlspecialchars($txn['date']) ?></td>
                          <td><?= htmlspecialchars($txn['category']) ?></td>
                          <td><?= htmlspecialchars($txn['subcategory']) ?></td>
                          <td><?= htmlspecialchars($txn['label']) ?></td>
                          <td class="<?= $txn['transaction_type'] === 'revenue' ? 'text-success' : 'text-danger' ?>">
                            <?= $txn['transaction_type'] === 'revenue' ? '+' : '-' ?>
                            <?= number_format($txn['amount'], 2, ',', ' ') ?> €
                          </td>
                          <td><?= htmlspecialchars($txn['observation']) ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php include '../includes/footer.php'; ?>
