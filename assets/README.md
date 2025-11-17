# Mon Projet d'Ateliers Pratiques Symfony 7

Ce projet est une application web de gestion d'articles (blog ou e-commerce simple) réalisée en suivant une série d'ateliers pratiques (TP). L'objectif était de moderniser un projet initialement prévu pour Symfony 4 vers **Symfony 7**, en utilisant les fonctionnalités modernes du framework comme les **Attributs PHP 8** et **AssetMapper**.

## 🚀 Fonctionnalités Implémentées

Le projet couvre les fonctionnalités de base d'une application web moderne :

* **Contrôleurs et Routage :** Configuration des routes avec les attributs `#[Route()]` (TP2).
* [cite_start]**Templates Twig :** Utilisation du moteur de template Twig avec héritage (`extends base.html.twig`) et inclusion de partiels (`include`) (TP3) [cite: 3205-3217].
* [cite_start]**Intégration de Bootstrap :** Utilisation de Bootstrap 4 via CDN pour le design (TP3) [cite: 3205-3217].
* **ORM Doctrine (CRUD) :** Opérations complètes de Création, Lecture, Mise à jour et Suppression (CRUD) pour l'entité `Article` (TP4).
* [cite_start]**Formulaires Avancés :** Création de classes de formulaire (`ArticleType`) avec `make:form` (TP5) [cite: 2768-2903].
* [cite_start]**Validation :** Ajout de contraintes de validation (`#[Assert\Length]`, `#[Assert\NotEqualTo]`) sur l'entité `Article` (TP5) [cite: 2862-2903].
* [cite_start]**Relations Doctrine :** Création d'une relation `OneToMany` entre les entités `Category` et `Article` (TP6) [cite: 2904-3187].
* **Formulaires de Recherche :**
    * Recherche par nom d'article sur la page d'accueil (TP7).
    * Recherche dédiée par catégorie (TP7).

## 🛠️ Prérequis

* PHP 8.2 ou supérieur
* Composer
* Symfony CLI
* Un serveur de base de données (ex: MariaDB ou MySQL)

## 📦 Installation

Suivez ces étapes pour faire fonctionner le projet en local :

1.  **Cloner le projet :**
    ```bash
    git clone [URL_DE_VOTRE_PROJET]
    cd [NOM_DU_DOSSIER]
    ```

2.  **Installer les dépendances :**
    ```bash
    composer install
    ```

3.  **Configurer la base de données :**
    * Copiez le fichier `.env` vers `.env.local` : `cp .env .env.local`
    * Ouvrez `.env.local` et modifiez la ligne `DATABASE_URL` pour correspondre à votre base de données locale. (Le projet a été développé avec `mysql://root:@localhost:3306/tps4?serverVersion=mariadb-10.4.11`).

4.  **Créer la base de données :**
    ```bash
    php bin/console doctrine:database:create
    ```

5.  **Exécuter les migrations :**
    Cette commande va créer les tables `article`, `category` et la table `messenger_messages`.
    ```bash
    php bin/console doctrine:migrations:migrate
    ```

## 🏃 Lancement

1.  **Démarrer le serveur local :**
    Utilisez le binaire Symfony CLI pour lancer le serveur web.
    ```bash
    symfony serve
    ```

2.  **Accéder à l'application :**
    Ouvrez votre navigateur et allez sur `http://127.0.0.1:8000`.

## 📋 Utilisation (Ordre recommandé)

Pour tester le projet :

1.  Allez sur `http://127.0.0.1:8000/category/new` pour **créer quelques catégories** (ex: "Smartphones", "PC Portables").
2.  Allez sur `http://127.0.0.1:8000/article/new` pour **créer quelques articles** en leur assignant des catégories.
3.  Retournez à l'accueil (`/`) pour voir la liste et **tester la recherche par nom**.
4.  Allez sur la page "Recherche par catégorie" pour **tester le filtre par catégorie**.

## 📚 Ateliers Réalisés

Ce projet est le résultat des ateliers suivants :
* [cite_start]**TP2 :** Création de Controller [cite: 3110-3129]
* [cite_start]**TP3 :** Twig et Bootstrap [cite: 3205-3217]
* **TP4 :** ORM Doctrine et Opérations CRUD
* [cite_start]**TP5 :** Formulaires et Validation [cite: 2768-2903]
* [cite_start]**TP6 :** Les entités et leurs Relations [cite: 2904-3187]
* **TP7 :** Formulaires de Recherche