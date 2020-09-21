Feature: User
    Allows to add and edit a user

    Rules:
    - A user with admin role can to add and edit a user

		Scenario: Add a user
			Given I Login as "user_1" with password "1"
			When I am on "users/create"
			When I fill form for user with  username "new_user", password "Hum123", a confirme password "Hum123", email "userNew@gmail.com" and roles "ROLE_USER"
			And I press "Ajouter"
			Then I should see "L'utilisateur a bien été ajouté"

		Scenario: Edit a user
			Given I Login as "user_1" with password "1"
			When I am on "users/59/edit"
			When I fill form for edit user with username "new_user", password "Hum123", a confirme password "Hum123", email "newemail@gmail.com" and roles "ROLE_USER"
			And I press "Modifier"
			Then I should see "L'utilisateur a bien été modifié"

		Scenario: Add a user without admin role
			Given I Login as "user_3" with password "1"
			When I am on "users/create"
			Then I should see "Access denied"

		Scenario: Edit a user without admin role
			Given I Login as "user_3" with password "1" 
			When I am on "users/19/edit"
			Then I should see "Access denied"