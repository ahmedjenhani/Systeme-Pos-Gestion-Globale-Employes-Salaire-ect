## ✨ Logiciel de Point de Vente Laravel

Gestion de point de vente et système de facturation construit avec Laravel 10 et MySQL.

![Dashboard](https://user-images.githubusercontent.com/71541409/234483153-38816efd-c261-4585-bb93-28639508f5e3.jpg)

## 🚀 Fonctionnalités
- Point de Vente (PDV)
- Commandes
  - Commandes en attente
  - Commandes complétées
  - Paiements dus
- Gestion des stocks
- Produits
  - Gestion des produits
  - Catégories
- Employés
- Clients
- Fournisseurs
- Salaires
  - Avances sur salaire
  - Paiement des salaires
  - Historique des paiements
- Présences
- Rôles et permissions
- Gestion des utilisateurs
- Sauvegarde de la base de données

## 🛠️ Comment utiliser

1. **Cloner le dépôt**
    ```bash
    $ git clone https://github.com/ahmedjenhani/Systeme_POS_Gestion_Inventaires_Employ-es.git
    ```

2. **Configuration initiale**
    ```bash
    $ cd SYSTEME POS
    $ composer install
    $ code .
    ```

3. **Configuration de l'environnement**
    ```bash
    $ cp .env.example .env
    $ php artisan key:generate
    ```

4. **Paramètre régional des données fictives**
    Ajouter dans `.env`:
    ```bash
    FAKER_LOCALE="fr_FR"
    ```

5. **Base de données**
    Configurer les identifiants dans `.env`

6. **Peupler la base**
    ```bash
    $ php artisan migrate:fresh --seed
    ```

7. **Lien de stockage**
    ```bash
    $ php artisan storage:link
    ```

8. **Démarrer le serveur**
    ```bash
    $ php artisan serve
    ```

9. **Connexion**
    Utilisateur : `administrateur` / Mot de passe : `password`

