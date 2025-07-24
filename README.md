# Budget Tracker

Petite application PHP/Bootstrap pour suivre vos revenus et vos dépenses en local.

## Installation
1. Créez une base de données `budget` dans MySQL et exécutez `sql/schema.sql`.
2. Copiez les fichiers dans votre serveur local (par ex. WAMP) et modifiez `includes/config.php` selon vos identifiants MySQL.
3. Démarrez un serveur PHP ou Apache et accédez à `login.php` pour créer un compte.

## Fonctionnalités
- Gestion des comptes, catégories, sous‑catégories et modes de paiement.
- Ajout, modification et suppression de transactions (revenus/dépenses).
- Filtre des transactions par mois/année avec totaux par catégorie.
