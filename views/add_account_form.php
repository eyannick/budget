<h2 class="mb-4">Ajouter un compte bancaire</h2>

<?php if ($message): ?>
  <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<form method="post" class="row g-3">
  <div class="col-md-6">
    <label for="name" class="form-label">Nom du compte</label>
    <input type="text" class="form-control" id="name" name="name" required>
  </div>
  <div class="col-md-6">
    <label for="balance" class="form-label">Solde initial (€)</label>
    <input type="number" step="0.01" class="form-control" id="balance" name="balance" required>
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-success">Ajouter le compte</button>
  </div>
</form>