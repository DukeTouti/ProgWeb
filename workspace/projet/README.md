# Gestion des Ventes et des Stocks d'un Magasin

## Description du Projet

Application web PHP pour la gestion complète des ventes et des stocks d'un magasin.
Le système permet la gestion des produits, des fournisseurs, des ventes via une interface
de caisse, et offre trois interfaces distinctes selon le profil utilisateur.

### Objectifs

- Gestion du catalogue produits avec catégories et fournisseurs
- Suivi des stocks en temps réel avec alertes de seuil
- Interface de caisse avec panier dynamique et calcul TTC automatique
- Historique des ventes et tableau de bord statistique
- Interface multi-rôles (Administrateur, Vendeur, Fournisseur)

---

## Architecture du Projet

### Structure des fichiers
```
workspace/
│
├── index.php                     # Front controller + router
├── config.php                    # Connexion PDO
├── database.sql                  # Schéma BDD + données de test
├── setup.php                     # Générateur de hash (à supprimer après usage)
│
├── src/
│   ├── Auth.php                  # Gardes de session et contrôle d'accès
│   └── Controller.php            # Classe mère abstraite (render, redirect)
│
├── models/
│   ├── user.php                  # Entité utilisateur + méthodes PDO
│   ├── category.php              # Entité catégorie + méthodes PDO
│   ├── supplier.php              # Entité fournisseur + méthodes PDO
│   ├── product.php               # Entité produit + méthodes PDO
│   ├── sale.php                  # Entité vente + méthodes PDO
│   └── saleitem.php              # Entité ligne de vente + méthodes PDO
│
├── controllers/
│   ├── AuthController.php        # Connexion / déconnexion
│   ├── ProductController.php     # CRUD produits + recherche
│   ├── SaleController.php        # Caisse + validation vente + historique
│   └── AdminController.php       # Dashboard + CRUD users + fournisseurs
│
└── views/
    ├── layout.php                # Template principal avec sidebar
    ├── login.php                 # Page de connexion
    ├── dashboard.php             # Tableau de bord
    ├── products/
    │   ├── index.php             # Liste produits + recherche
    │   ├── form.php              # Formulaire ajout/modification
    │   └── delete.php            # Confirmation suppression
    ├── sales/
    │   ├── caisse.php            # Interface caisse avec panier JS
    │   ├── confirmation.php      # Récapitulatif vente validée
    │   └── history.php           # Historique des ventes
    └── admin/
        ├── users.php             # Liste utilisateurs
        ├── user_form.php         # Formulaire ajout/modification utilisateur
        ├── suppliers.php         # Liste fournisseurs
        ├── supplier_form.php     # Formulaire ajout/modification fournisseur
        └── delete.php            # Confirmation suppression générique
```

---

## Installation

### Pré-requis

- PHP 8.0+
- MySQL Server 5.7+

### Mise en place

**1. Créer la base de données et l'utilisateur MySQL :**
```bash
sudo mysql
```
```sql
CREATE DATABASE GestionMagasin CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
CREATE USER 'magasin'@'localhost' IDENTIFIED BY 'magasin123';
GRANT ALL ON GestionMagasin.* TO 'magasin'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

**2. Importer le schéma et les données de test :**
```bash
sudo mysql GestionMagasin < database.sql
```

**3. Générer les hash des mots de passe :**
```bash
php -S localhost:8080
```

Ouvrir `http://localhost:8080/setup.php` dans le navigateur,
copier les trois requêtes `UPDATE` affichées et les exécuter :
```bash
sudo mysql GestionMagasin
```
```sql
UPDATE users SET password = '$2y$10$...' WHERE login = 'admin';
UPDATE users SET password = '$2y$10$...' WHERE login = 'vendeur1';
UPDATE users SET password = '$2y$10$...' WHERE login = 'fournisseur1';
EXIT;
```

**4. Supprimer setup.php et relancer le serveur :**
```bash
rm setup.php
php -S localhost:8080
```

**5. Accéder à l'application :**
```
http://localhost:8080
```

---

## Comptes de test

|    Login     | Mot de passe |      Rôle      |          Accès          |
|--------------|--------------|----------------|-------------------------|
| admin        | admin123     | Administrateur | Complet                 |
| vendeur1     | vendeur123   | Vendeur        | Caisse + Catalogue      |
| fournisseur1 | fourn123     | Fournisseur    | Ses produits uniquement |

---

## Technologies utilisées

- **Backend :** PHP 8.0+ — 100% Orienté Objet
- **Base de données :** MySQL — PDO avec requêtes préparées
- **Frontend :** HTML, CSS, JavaScript
- **Architecture :** MVC avec front controller unique
- **Sécurité :** bcrypt (password_hash), sessions PHP, requêtes préparées

---

## Équipe de développement

- HATHOUTI Mohammed Taha
- JIDAL Ilyas
- KABORÉ Mohammed Sharif Jonathan

---

Projet académique - ESIN 3A Cybersécurité - UIR - 2025/2026

**Dernière mise à jour :** Avril 2026
