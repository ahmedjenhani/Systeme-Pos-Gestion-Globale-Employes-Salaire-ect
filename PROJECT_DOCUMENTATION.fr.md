# Documentation du Système POS 

## Architecture Générale  
**Implémentation du Modèle MVC**  
- Backend : Laravel (Framework PHP)  
- Frontend : Templates Blade + JavaScript  
- Base de données : MySQL (Base de données relationnelle)  

## Technologies Clés  
**Stack Backend**  
- PHP 8.x  
- Laravel 10.x  
- Eloquent ORM  
- MySQL 8.x  

**Stack Frontend**  
- Tailwind CSS  
- Système de build Vite  
- Icônes Line Awesome  
- Icônes Remix  

**Packages Principaux**  
- Spatie Permission (Gestion des rôles)  
- Laravel ID Generator (Génération de codes produits)  
- Laravel Sanctum (Authentification API)  

## Composants Clés  

### 1. Système de Gestion des Utilisateurs  
- Contrôle d'accès basé sur les rôles (RBAC)  
  - SuperAdmin : Accès complet  
  - Administrateur : Gestion utilisateurs/clients/fournisseurs  
  - Comptable : Opérations financières  
  - Manager : Gestion stock/commandes  

### 2. Gestion des Stocks  
- Catalogue produits avec catégories  
- Système de suivi des stocks  
- Gestion des fournisseurs 
- Gestion des Employées etc ... 

### 3. Opérations PDV  
- Traitement des commandes  
- Gestion des clients  
- Suivi des ventes  

### 4. Gestion RH  
- Fiches employés  
- Suivi des présences  
- Système d'avances sur salaire  

## Détails Techniques  

### Structure de la Base de Données  
```plaintext  
├── users  
├── employees  
├── customers  
├── suppliers  
├── products  
├── orders  
├── order_details  
├── categories  
└── permissions (via Spatie)  
```  

### Modèles Principaux  
- **Product** : Gère les articles d'inventaire avec codes uniques  
- **Order** : Gère les transactions avec relations vers :  
  - OrderDetails (lignes de commande)  
  - Customers  
  - Employees (vendeurs)  

### Sécurité  
- Protection CSRF  
- Cookies chiffrés  
- Matrice rôles-permissions  
- Hachage des mots de passe (bcrypt)  

## Points de Terminaison API (web.php)  
- Routes d'authentification (/login, /register)  
- Routes dashboard  
- Contrôleurs ressource pour :  
  - /products  
  - /orders  
  - /customers  
  - /employees  

## Configuration du Développement  
1. Prérequis :  
   - PHP 8.1+  
   - Composer  
   - Node.js 16+  
   - MySQL 5.7+  

2. Installation :  
```bash  
composer install  
npm install  
cp .env.example .env  
php artisan key:generate  
```  

## Déploiement  
- Configuration serveur XAMPP/WAMP  
- Variables d'environnement de production  
- Stratégie de sauvegarde de base de données  
- Tâches planifiées :  
  - Calculs de salaires  
  - Alertes de stock  


