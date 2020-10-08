# ToDoList

ToDoList est une application qui permet de gérer différentes tâches.


## Installation du projet

1. Cloner le projet : **git clone https://github.com/GeoffroyCOL/Todolist.git**
2. Installer des dépendances : **composer install**
3. Créer la base de données : **php bin/console doctrine:database:create**
4. Créations des tables : **php bin/console make:migration** et **php bin/console doctrine:migrations:migrate**
5. Chargement des fixtures : **php bin/console doctrine:fixtures:load**


## Démarrage

Pour démarrer l'application en local

```bash
Symfony serve -d
```

## Frabriquer avec

```bash
Symfony 4.4
PHP 7.3
Bootstrap 4
```

## Contribution

Si vous souhaitez contribuer, lisez le fichier contribution.md


## Librairies

1. [flex](https://symfony.com/doc/current/quick_tour/flex_recipes.html)
```bash
composer require symfony/flex
```

2. [annotation](https://symfony.com/doc/current/routing.html)
```bash
composer require doctrine/annotations
```

3. [asset](https://symfony.com/doc/current/components/asset.html)
```bash
composer require symfony/asset
```

4. [orm-pack](https://symfony.com/doc/current/doctrine.html)
```bash
composer require symfony/orm-pack
```

5. [twig](https://symfony.com/doc/current/templates.html)
```bash
composer require symfony/twig-bundle
```

6. [validator](https://symfony.com/doc/current/components/validator.html)
```bash
composer require symfony/validator
```

7. [logger](https://symfony.com/doc/current/logging.html)
```bash
composer require symfony/monolog-bundle
```

8. [mailer](https://symfony.com/doc/current/mailer.html)
```bash
composer require symfony/mailer
```

9. [PHPUnit](https://symfony.com/doc/current/testing.html)
```bash
composer require --dev symfony/phpunit-bridge
```

10. [form](https://symfony.com/doc/current/forms.html)
```bash
composer require symfony/form
```

11. [security](https://symfony.com/doc/current/security.html)
```bash
composer require symfony/security-bundle
```

12. [translation](https://symfony.com/doc/current/translation.html)
```bash
composer require symfony/translation
```

13. [behat](https://docs.behat.org/en/latest/)
```bash
composer require --dev behat/behat
```

14. [maker-bundle](https://symfony.com/doc/current/doctrine.html)
```bash
composer require --dev symfony/maker-bundle
```

15. [orm-fixtures](https://symfony.com/doc/master/bundles/DoctrineFixturesBundle/index.html)
```bash
composer require --dev orm-fixtures
```

16. [profiler](https://symfony.com/doc/current/profiler.html)
```bash
composer require --dev symfony/profiler-pack
```

17. [dotenv](https://symfony.com/doc/3.4/components/dotenv.html)
```bash
composer require symfony/dotenv
```