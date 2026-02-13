-- Données de test pour Takalo

-- Admin test (mot de passe: admin123)
INSERT INTO user_takalo (id_role, username, email, hashedpassword) 
VALUES (1, 'Admin', 'admin@takalo.test', '$2y$10$J7EvKxe/2.L0yfKzsA8ZN.qZd4sT6h8h9QY5yI3VfDhX/nBZRp1Ce');

-- Utilisateurs test (mot de passe: user123)
INSERT INTO user_takalo (id_role, username, email, hashedpassword) 
VALUES 
(2, 'Alice', 'alice@test.com', '$2y$10$J7EvKxe/2.L0yfKzsA8ZN.qZd4sT6h8h9QY5yI3VfDhX/nBZRp1Ce'),
(2, 'Bob', 'bob@test.com', '$2y$10$J7EvKxe/2.L0yfKzsA8ZN.qZd4sT6h8h9QY5yI3VfDhX/nBZRp1Ce');

-- Catégories
INSERT INTO categorie_takalo (nom) 
VALUES ('Électronique'), ('Vêtements'), ('Livres'), ('Jouets'), ('Meubles');
