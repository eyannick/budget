
-- Création d'un utilisateur
INSERT INTO users (first_name, last_name, email, password) VALUES
('Jean', 'Dupont', 'jean.dupont@example.com', 'password_hash');

-- Création de comptes pour l'utilisateur
INSERT INTO accounts (user_id, name, initial_balance) VALUES
(1, 'Compte courant', 1200.00),
(1, 'Livret A', 3000.00);

-- Création de catégories
INSERT INTO categories (user_id, name, parent_id) VALUES
(1, 'Revenus', NULL),
(1, 'Épargne', NULL),
(1, 'Immobilier', NULL),
(1, 'Véhicules', NULL),
(1, 'Assurances / Mutuelle / Santé', NULL),
(1, 'Numérique', NULL),
(1, 'Divers', NULL),

-- Sous-catégories
(1, 'Revenus personnels', 1),
(1, 'Revenus locatifs', 1),
(1, 'Livret bleu', 2),
(1, 'Compte épargne logement', 2),
(1, 'Bien immobilier (46 Blvd St-Joseph)', 3),
(1, 'Ford Fiesta', 4),
(1, 'Assurance voiture', 5),
(1, 'Réparations véhicule', 4);

-- Ajout de transactions
INSERT INTO transactions (user_id, account_id, category_id, subcategory_id, label, amount, transaction_type, date, observation) VALUES
(1, 1, 1, 8, 'Salaire Juillet', 2500.00, 'revenue', '2025-07-01', 'Salaire mensuel'),
(1, 1, 5, 13, 'Assurance auto', 60.00, 'expense', '2025-07-05', 'Mensualité'),
(1, 1, 4, 14, 'Garage - réparation freins', 250.00, 'expense', '2025-07-10', 'Entretien'),
(1, 2, 2, 10, 'Transfert vers CEL', 300.00, 'transfer', '2025-07-15', 'Épargne mensuelle');
