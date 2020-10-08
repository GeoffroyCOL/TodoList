# ToDoList

ToDoList est une application qui permet de gérer différentes tâches à réaliser.

---------------------------------------------------

## Installation du projet

1. Cloner le projet : **git clone https://github.com/GeoffroyCOL/Todolist.git**
2. Installer des dépendances : **composer install**
3. Créer la base de données : **php bin/console doctrine:database:create**
4. Créations des tables : **php bin/console make:migration** et **php bin/console doctrine:migrations:migrate**
5. Chargement des fixtures : **php bin/console doctrine:fixtures:load**
6. Modification dans le fichie .env : **DATABASE_URL=mysql://root@127.0.0.1:3306/todolist?serverVersion=5.7**


## Démarrage

Pour démarrer l'application en local

```bash
Symfony serve -d
```

----------------------------------------------------

## Frabriquer avec

```bash
Symfony 4.4 - Framework PHP
PHP 7.3
Bootstrap 4 - Framework CSS
```

----------------------------------------------------

## Contribution

Si vous souhaitez contribuer, lisez le fichier contribution.md.


------------------------------------------------------

## Librairies

1. Flex
```bash
composer require symfony/flex
```

2. 

-----------------------------------------------------

## Autheur