# Documentation technique 


## 1/ Règles de codage

L'application respecte les normes PSR-1 et PSR-2.


## 2/ Audit

Les différents outils pour la vérification de la qualité du code et de ses performances :

* Codacy : Pour la qualité du code
* Blackfire : Pour les performances de l'application.


## 3/ Version de Symfony

La version choisie pour la mise à jour de symfony est la version 4.4 (TLS)
Son support est garanti jusqu’en novembre 2022, et les bugs de sécurité pendant encore un an de plus, 2023.


## 4/ Tests

Les différentes librairies utilisées pour les tests unitaires et fonctionnels :
* [PHPUnit](https://symfony.com/doc/current/testing.html)
* [behat](https://docs.behat.org/en/latest/)


## 5/ Fixtures

La librairie utilisée est [faker](https://github.com/fzaninotto/Faker)


## 5/ Couverture de test

La couverture de test effectuée est de 94.85%.  


## 6/ [Bonnes pratiques](https://symfony.com/doc/current/best_practices.html)

* Utilisation de service dans les controllers
* Création des routes avec les annotations
* Contrainte de validation dans les class Entity


## 7/ Etapes

La procédure de contribution : 

1. Création de l'issu

2. Création de la branche pour la réalisation de cette issue

3. Codage

4. Tests

5. Création de la pull request

6. Revue de code

7. Merger la branche



## 8/ Architecture

La liste des différents dossier qui contient le code de l'application sont:
* src
* templates
 

### 8-1/ Le dossier scr

Il est composé de plusieurs dossiers:
* Controllers
* DataFixtures
* Entity
* Form
* Repository
* Security
* Service


#### 8-2/ Controllers

Le dossier qui contient tous les controllers de l'application : 
* **DefaultController.php**: Controller pour la page d'accueil
* **SecurityController.php**: Pour la connexion et déconnexion
* **TaskController.php**: Pour la gestion des différentes tâches et les différentes informations.
* **UserController.php**: Pour la gestion des différents utilisateurs et les différentes informations.


#### 8-3/ Entity

Ce dossier contient les entités doctrines :
* User.php
* Task.php


#### 8-4/ Form

Les différents formulaires qui sont :
* **TaskType.php** : Pour ajouter / modifier une tâche
* **UserEditType.php** : Pour modifier un utilisateur
* **UserType.php** : Pour ajouter un utilisateur  


#### 8-5/ Repository

Permets de pouvoir faire différentes requêtes à la base de données
* UserRepository.php
* TaskRepository.php


#### 8-6/ Security

Contient les fichiers de sécurité :
* **LoginFormAuthentificator.php** :Pour l'authentification
* **Voter/TaskVoter.php** :Qui permet de donner le droit de pouvoir modifieret / ou supprimer une tâche selon certaines conditions.


#### 8-7/ Service

Fichier qui permet de manipuler les différentes entités : 
* UserHandler.php
* TaskHandler.php


### 8-8/ Templates

Ce dossier contient les différents templates.
* **Default** : Contient le fichier *index.html.twig* pour afficher la page d'accueil
* **Security** : Contient le fichier *login.html.twig* pour afficher le formulaire de connexion
* **Task** : Les différents templates pour ajouter (*create.html.twig*), modifier (*edit.html.twig*) et lister les différentes tâches (*list.html.twig*)
* **User**: Les différents templates pour ajouter (*create.html.twig*), modifier (*edit.html.twig*) et lister les différents utilisateurs (*list.html.twig*)
* **base.html.twig** 
* **message-flash.html.twig**














