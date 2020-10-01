ToDoList
========

Base du projet #8 : Améliorez un projet existant

---------------------------------------------------

## Installation du projet

1. Cloner le projet : **git clone https://github.com/GeoffroyCOL/Todolist.git**
2. Installer des dépendances : **composer install**
3. Créer la base de données : **php bin/console doctrine:database:create**
4. Créations des tables : **php bin/console make:migration** et **php bin/console doctrine:migrations:migrate**
5. Chargement des fixtures : **php bin/console doctrine:fixtures:load**