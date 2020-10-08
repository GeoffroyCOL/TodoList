Feature: loggin
  Allows a user to log in with usernamen and password
  
  Scenario: User logged
    Given I login as "user_1" with password "Hum123"
    Then I should see "Bienvenue sur Todo List"