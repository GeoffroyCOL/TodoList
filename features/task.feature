Feature: Task
  Allows to add, edit and delete a Task

  Rules:
    - A user must be logged in to add, edit and delete a task
    - A user can edit and delete only his task
    - A user with admin role can to edit and delete a task create by anonyme


  Scenario: Add a task
    Given I Login as "user_1" with password "1"
    When I am on "/tasks/create"
    When I fill the form for task "Nouveau tâche ajoutée" and "Le contenue à réaliser"
    And I press "Ajouter"
    Then I should see "La tâche a été bien été ajoutée."


  Scenario: Edit my task
    Given I Login as "user_1" with password "1"
    When I am on "/tasks/14/edit"
    When I fill the form for task "Modifié le titre" and "Modifier le contenu"
    And I press "Modifier"
    Then I should see "La tâche a bien été modifiée."


  Scenario: Edit a task don't create
    Given I Login as "user_1" with password "1"
    When I am on "/tasks/10/edit"
    Then I should see "Vous ne pouvez pas modifier cette tâche"


  Scenario: Delete a task don't create and without admin role
    Given I Login as "user_3" with password "1"
    When I am on "/tasks/4/delete"
    Then I should see "Vous ne pouvez pas supprimer cette tâche"


  #Scenario: Delete my task
  # Given I Login as "user_1" with password "1"
  #  When I am on "/tasks/43/delete"
  #  Then I should see "La tâche a bien été supprimée"


  #Scenario: Delete a task create by anonyme with a admin role
  #  Given I Login as "user_1" with password "1"
  #  When I am on "/tasks/44/delete"
  #  Then I should see "La tâche a bien été supprimée"