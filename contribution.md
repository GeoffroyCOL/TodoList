# Documentation technique 

## 1/ Architecture

La liste des différents dossier qui contient le code de l'application sont:
* src
* templates
 
### 1-1/ Le dossier scr

Il est composé de plusieurs dossiers:
* Controllers
* DataFixtures
* Entity
* Form
* Repository
* Security
* Service

#### 1-1-a/ Controllers

Le dossier qui contient tous les controllers de l'application : 
* **DefaultController.php**: Controller pour la page d'accueil
* **SecurityController.php**: Pour la connexion et déconnexion
* **TaskController.php**: Pour la gestion des différentes tâches et les différentes informations.
* **UserController.php**: Pour la gestion des différents utilisateurs et les différentes informations.

#### 1-1-b/ DataFixtures
Ce dossier contient les fichiers pour fournir des fausses données pour les tâches et les utilisateurs.

#### 1-1-c/ Entity

Ce dossier contient les entités doctrines :
* User.php
* Task.php

#### 1-1-d/ Form

Les différents formulaires qui sont :
* **TaskType.php** : Pour ajouter / modifier une tâche
* **UserEditType.php** : Pour modifier un utilisateur
* **UserType.php** : Pour ajouter un utilisateur  

#### 1-1-e/ Repository

Permets de pouvoir faire différentes requêtes à la base de données
* UserRepository.php
* TaskRepository.php


#### 1-1-f/ Security

Contient les fichiers de sécurité :
* **LoginFormAuthentificator.php** :Pour l'authentification
* **Voter/TaskVoter.php** :Qui permet de donner le droit de pouvoir modifieret / ou supprimer une tâche selon certaines conditions.

#### 1-1-g/ Service

Fichier qui permet de manipuler les différentes entités : 
* UserHandler.php
* TaskHandler.php

### 1-2/ Templates

Ce dossier contient les différents templates.
* **Default** : Contient le fichier *index.html.twig* pour afficher la page d'accueil
* **Security** : Contient le fichier *login.html.twig* pour afficher le formulaire de connexion
* **Task** : Les différents templates pour ajouter (*create.html.twig*), modifier (*edit.html.twig*) et lister les différentes tâches (*list.html.twig*)
* **User**: Les différents templates pour ajouter (*create.html.twig*), modifier (*edit.html.twig*) et lister les différents utilisateurs (*list.html.twig*)
* **base.html.twig** 
* **message-flash.html.twig**

--------------------------------------

## 2/ Entités

Les différentes entités de l'application sont: 
1. **User** : qui représente les utilisateurs
2. **Task** : qui représente les tâches effectuées ou réalisées.

Les contraintes de validations lors de la gestion de ces entités sont contenue dans ces fichiers.

Si vous souhaitez ajouter un nouveau champ ou bien modifier une contrainte pour la gestion d'une entité, cela se fera dans le fichier de l'entité choisie.

Si vous souhaitez créer une nouvelle entité alors il faudra 
* Créer un service ( de la forme EntityHandler.php dans le dossier Service )
* Mettre dans le fichier de l'entity les contraintes de validation
* Créer un formulaire pour la gestion de l'entité

---------------------------------

## 3/ Les controllers

Le format pour chaque route : 
* **entity/action** : par exemple pour créer une nouvelle tâche *task/create*
* **entity/:id/action** : Par exemple pour modifier une tâche précise *task/2/edit*

L'id représente l'identifiant de l'entité pour, par exemple pour suppression ou modification.

Si vous souhaitez ajouter une nouvelle méthode dans un controller, alors :
* Utiliser les annotations pour les routes
* Utiliser les services pour la logique métier.

-------------------------------------------------------

## 4/ Services

Les différents services pour chaque entité (User et Task ) possèdent :
* Des méthodes de gestion : *add* / *edit* / *delete*
* Une méthode de récupération de données : *getAll*

Si vous souhaitez ajouter une méthode, par exemple la récupération des données d'une tâche ( getTask ), alors vous le ferait dans le fichier TaskHandler.php.

----------------------------------------------------------

## 5/ Templates

Chaque entité possède :
* Un template pour le formulaire d'ajout : *create.html.twig*
* Un template pour le formulaire de modification : *edit.html.twig*
* Un formulaire pour afficher la liste des entités : *list.html.twig*

Pour l'entité Task, un template *task.html.twig* est utilisé pour représenter une tâche.

Si un champs est ajouté, modifié et / ou supprimé alors :
* Modifier les templates qui affichent les information sur l'entité
* Modifier les templates de formulaire pour la gestion des champs.

-----------------------------------------------------------

## 6/ Les formulaires 

Si un attribut est ajouté, modifié ou bien supprimé dans une entité alors il faudra penser à le faire dans les fichiers de formulaire ( *Type.php )

Pour l'entity User, il existe deux formulaires :
* **UserType** :Qui permet d'ajouter un utilisateur
* **UserEditType.php** :Qui permet de modifier un utilisateur

Le formulaire *UserEditType* est un formulaire enfant de *UserType* 
Il utilise les mêmes champs sauf pour le mot de passe.
Il utilise un autre attribut que password ( newPassword ) pour la modification de celui-ci

Si vous souhaitez ajouter un attribut qui soit utilisé pour l'ajout et la modification d'un utilisateur, alors ajoute le dans le *UserType.php*

Il faut penser également à modifier les templates qui affiche les différents champs du formulaire formulaires.

-----------------------------------------------------------

## 7/ Etapes

La procédure de contribution : 

```bash
* Créer une issue
* Création de la branche pour la réalisation
* Codage
* Teste
* Créer une pull request
* Revue de code
* Merger la branche
```















