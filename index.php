<?php
require_once __DIR__.'/includes/auth.php';
require_login();
require_once __DIR__.'/includes/header.php';
?>
<h1 class="mb-4">Tableau de bord</h1>
<p>Bienvenue sur votre application de suivi de budget.</p>
<p>Utilisez le menu pour gérer vos transactions et listes.</p>
<?php
require_once __DIR__.'/includes/footer.php';
