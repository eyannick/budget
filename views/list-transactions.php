<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Liste des transactions</h2>

    <?php if (empty($transactions)) : ?>
        <div class="alert alert-info">Aucune transaction trouvée.</div>
    <?php else : ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Compte</th>
                    <th>Compte cible</th>
                    <th>Catégorie</th>
                    <th>Sous-catégorie</th>
                    <th>Libellé</th>
                    <th>Observation</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $t) : ?>
                    <tr>
                        <td><?= htmlspecialchars($t['date']) ?></td>
                        <td><?= ucfirst($t['transaction_type']) ?></td>
                        <td class="<?= $t['amount'] < 0 ? 'text-danger' : 'text-success' ?>">
                            <?= number_format($t['amount'], 2, ',', ' ') ?> €
                        </td>
                        <td><?= htmlspecialchars($t['account_name']) ?></td>
                        <td><?= htmlspecialchars($t['target_account_name'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($t['category_name'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($t['subcategory_name'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($t['label'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($t['observation'] ?? '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
