# TAKALO - Plateforme d'Échange d'Objets

## Fonctionnalités Implémentées (Partie 1/2)

### 1. Backoffice (Admin)

#### a. Login Admin
- **Route:** `/admin/login`
- **Identifiants par défaut:**
  - Email: `admin@takalo.test`
  - Mot de passe: `admin123`
- Login pré-rempli sur le formulaire
- Authentification sécurisée avec vérification du rôle admin (role_id = 1)

#### b. Gestion des Catégories
- **Route:** `/admin/categories`
- CRUD complet:
  - ✅ Créer une catégorie
  - ✅ Lister toutes les catégories
  - ✅ Modifier une catégorie
  - ✅ Supprimer une catégorie

---

### 2. Frontoffice (Utilisateur)

#### a. Inscription et Login
- **Routes:** `/login`, `/register`
- Inscription avec email, username et mot de passe
- Login sécurisé avec hashage bcrypt
- Validation des champs (email, longueur)

#### b. Gestion de ses Objets
- **Route:** `/objects/mine`
- **Objet contient:**
  - Titre (nom_objet)
  - Description
  - 1 ou plusieurs photos (table `objet_photo_takalo`)
  - Prix estimatif
  - Catégorie (optionnelle)
- CRUD complet:
  - ✅ Créer un objet avec upload de photos
  - ✅ Voir ses objets
  - ✅ Modifier un objet
  - ✅ Supprimer un objet

#### c. Liste des Objets des Autres Utilisateurs
- **Route:** `/objects`
- Affiche tous les objets sauf les siens
- Vue en grille avec aperçu (titre, prix, catégorie, propriétaire)

##### Fiche Objet
- **Route:** `/objects/{id}`
- Détails complets: titre, description, prix, catégorie, photos, propriétaire
- **Proposition d'échange:**
  - Sélection d'un de ses objets à proposer
  - Création d'une proposition via formulaire

#### d. Gestion des Échanges
- **Route:** `/exchanges`

##### Liste des Propositions
- Deux sections:
  - **Propositions reçues:** objets que d'autres veulent échanger contre les tiens
  - **Propositions envoyées:** tes propositions d'échange

##### Acceptation ou Refus
- Boutons "Accepter" / "Refuser" sur les propositions reçues
- Statuts: `pending`, `accepted`, `refused`
- Horodatage: `created_at`, `responded_at`

---

## Structure SQL

### Tables Principales
- **user_role_takalo:** rôles (admin, user)
- **user_takalo:** utilisateurs
- **categorie_takalo:** catégories d'objets
- **objet_takalo:** objets avec catégorie
- **objet_photo_takalo:** photos multiples par objet
- **echange_takalo:** propositions d'échange

### Fichiers
- **Schema:** `data/table.sql`
- **Données de test:** `data/insert.sql`

---

## Architecture MVC

### Models (`app/models/`)
- `CategoryModel.php`: CRUD catégories
- `ObjectModel.php`: CRUD objets + photos
- `ExchangeModel.php`: gestion échanges

### Controllers (`app/controllers/`)
- `BaseController.php`: helper auth/flash
- `AdminController.php`: login admin
- `CategoryController.php`: CRUD catégories
- `LoginController.php`: login/register utilisateur
- `HomeController.php`: page d'accueil
- `ObjectController.php`: gestion objets + propositions
- `ExchangeController.php`: liste + accept/refuse

### Views (`app/views/`)
- `admin/`: login, categories, category_edit
- `objects/`: mine, form, list, show
- `exchanges/`: index
- `login.php`, `home.php`

### Routes (`app/config/routes.php`)
Toutes les routes HTTP configurées avec FlightPHP Router.

---

## Installation & Test

### 1. Base de données
```bash
mysql -u root -p
CREATE DATABASE takalo;
USE takalo;
source data/table.sql;
source data/insert.sql;
```

### 2. Configuration
Vérifier `app/config/config.php`:
```php
'database' => [
    'host'     => '127.0.0.1',
    'dbname'   => 'takalo',
    'user'     => 'root',
    'password' => '',
]
```

### 3. Lancer le serveur
```bash
php -S localhost:8081 -t public
```

### 4. Accès
- **Frontoffice:** http://localhost:8081/login
- **Backoffice:** http://localhost:8081/admin/login

### Comptes de test
- **Admin:** `admin@takalo.test` / `admin123`
- **User 1:** `alice@test.com` / `user123`
- **User 2:** `bob@test.com` / `user123`

---

## Upload de Photos
Les photos sont stockées dans: `public/assets/uploads/`
Formats supportés: JPEG, PNG, GIF, WEBP

---

## Sécurité
- Mots de passe hashés avec `password_hash()` (bcrypt)
- Validation des entrées utilisateur
- Authentification par session
- Protection CSRF (via SecurityHeadersMiddleware)
- Vérification des propriétaires pour les actions (édition, suppression)

---

## Prochaines Étapes (Partie 2)
Extension possible: notifications, historique, filtres, recherche, etc.
