CREATE DATABASE IF NOT EXISTS GestionMagasin CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE GestionMagasin;

CREATE TABLE users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	nom VARCHAR(100) NOT NULL,
	prenom VARCHAR(100) NOT NULL,
	login VARCHAR(60) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL,
	role ENUM('admin','vendeur','fournisseur') NOT NULL DEFAULT 'vendeur',
	created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
	id INT AUTO_INCREMENT PRIMARY KEY,
	nom VARCHAR(100) NOT NULL
);

CREATE TABLE suppliers (
	id INT AUTO_INCREMENT PRIMARY KEY,
	nom VARCHAR(100) NOT NULL,
	email VARCHAR(150),
	telephone VARCHAR(20),
	id_user INT DEFAULT NULL,
	FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE products (
	id INT AUTO_INCREMENT PRIMARY KEY,
	nom VARCHAR(150) NOT NULL,
	description TEXT,
	prix_achat DECIMAL(10,2) NOT NULL DEFAULT 0.00,
	prix_vente DECIMAL(10,2) NOT NULL DEFAULT 0.00,
	quantite_stock INT NOT NULL DEFAULT 0,
	seuil_alerte INT NOT NULL DEFAULT 5,
	id_categorie INT DEFAULT NULL,
	id_fournisseur INT DEFAULT NULL,
	FOREIGN KEY (id_categorie) REFERENCES categories(id) ON DELETE SET NULL,
	FOREIGN KEY (id_fournisseur) REFERENCES suppliers(id) ON DELETE SET NULL
);

CREATE TABLE sales (
	id INT AUTO_INCREMENT PRIMARY KEY,
	id_vendeur INT NOT NULL,
	total_ttc DECIMAL(10,2) NOT NULL DEFAULT 0.00,
	date_vente DATETIME DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (id_vendeur) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE sale_items (
	id INT AUTO_INCREMENT PRIMARY KEY,
	id_vente INT NOT NULL,
	id_produit INT NOT NULL,
	quantite INT NOT NULL,
	prix_unitaire DECIMAL(10,2) NOT NULL,
	FOREIGN KEY (id_vente) REFERENCES sales(id) ON DELETE CASCADE,
	FOREIGN KEY (id_produit) REFERENCES products(id) ON DELETE CASCADE
);

-- Utilisateurs (passwords générés par setup.php)
INSERT INTO users (nom, prenom, login, password, role) VALUES
('Admin', 'Super', 'admin', '$2y$10$PLACEHOLDER_ADMIN', 'admin'),
('Dupont', 'Jean', 'vendeur1', '$2y$10$PLACEHOLDER_VENDEUR', 'vendeur'),
('Martin', 'Sophie', 'fournisseur1', '$2y$10$PLACEHOLDER_FOURN', 'fournisseur');

-- Catégories
INSERT INTO categories (nom) VALUES
('Électronique'),
('Alimentation'),
('Vêtements'),
('Informatique'),
('Téléphonie');

-- Fournisseurs
INSERT INTO suppliers (nom, email, telephone, id_user) VALUES
('TechPro SARL', 'contact@techpro.ma', '0661234567', 3),
('FoodSupply', 'info@foodsupply.ma', '0662345678', NULL),
('ModaMaroc', 'contact@modamaroc.ma', '0663456789', NULL);

-- Produits
INSERT INTO products (nom, description, prix_achat, prix_vente, quantite_stock, seuil_alerte, id_categorie, id_fournisseur) VALUES
('Laptop Dell Core i5', 'Core i5 8Go RAM 256Go SSD', 4500.00, 6200.00, 12, 3, 1, 1),
('Clé USB 64Go', 'USB 3.0 haute vitesse', 45.00, 89.00, 50, 10, 4, 1),
('Souris sans fil', 'Souris optique 2.4GHz', 80.00, 149.00, 4, 5, 4, 1),
('iPhone 14', '128Go Noir', 8500.00, 11000.00, 8, 3, 5, 1),
('Samsung A54', '256Go Blanc', 3200.00, 4500.00, 3, 5, 5, 1),
('Huile d\'olive 1L', 'Huile d\'olive bio', 25.00, 42.00, 60, 10, 2, 2),
('Café Arabica 500g', 'Café en grains torréfié', 55.00, 89.00, 30, 8, 2, 2),
('T-shirt basic', '100% coton, tailles S à XL', 35.00, 75.00, 3, 5, 3, 3),
('Jean slim', 'Coupe slim, bleu foncé', 120.00, 249.00, 15, 5, 3, 3),
('Casque Bluetooth', 'Autonomie 20h, réduction de bruit', 350.00, 599.00, 2, 3, 1, 1);
