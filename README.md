# SymfonyPress

### Description du projet

SymfonyPress est un projet académique développé avec Symfony.
Il met en place un système de gestion d’articles avec authentification des utilisateurs et une séparation claire entre les fonctionnalités publiques et administrateur.

### Fonctionnalités

- Authentification et gestion des utilisateurs
- Création, modification et suppression d’articles par leur auteur
- Affichage des derniers articles publiés
- Navigation des articles par catégories
- Back-office administrateur permettant de gérer les articles

### Lancer le projet

- Télécharger le projet : ```git clone https://github.com/thomasr10/SymfonyPress.git```
- Installer les dépendances : ```composer install```
- Créer la base de donnée : ```symfony console doctrine:database:create```
- Effectuer la migration : ```symfony console doctrine:migrations:migrate```
- Démarrer le server : ```symfony server:start``` 