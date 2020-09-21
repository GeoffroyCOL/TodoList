Feature: loggin
  Allows a user to log in with usernamen and password
  
  Scenario: User logged
    Given I login as "user_1" with password "1"
    Then I should see "Bienvenue sur Todo List, l'application vous permettant de gérer l'ensemble de vos tâches sans effort !"