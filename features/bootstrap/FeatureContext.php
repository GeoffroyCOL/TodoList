<?php

use App\Entity\Task;
use App\Service\TaskHandler;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\Gherkin\Node\PyStringNode;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Behat\Context\SnippetAcceptingContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given I login as :username with password :password
     */
    public function iLoginAsWithPassword(string $username, string $password) {
        $this->visit("/login");
        $this->fillField("_username", $username);
        $this->fillField("_password", $password);
        $this->pressButton("Se connecter");
    }

    /**
     * @When I fill the form for task :title and :content
     */
    public function iFillTheFormForTaskAnd(string $title, ?string $content)
    {
        $this->fillField("task_title", $title);
        $this->fillField("task_content", $content);
    }

    /**
     * @When I fill form for user with  username :username, password :password, a confirme password :confirmPassword, email :email and roles :roles
     */
    public function iFillFormForUserWithUsernamePasswordAConfirmePasswordEmailAndRoles(string $username, string $password, string $confirmPassword, string $email, string $roles)
    {
        $this->fillField("user[username]", $username);
        $this->fillField("user[password][first]", $password);
        $this->fillField("user[password][second]", $confirmPassword);
        $this->fillField("user[email]", $email);
        $this->fillField("user[roles]", $roles);
    }

    /**
     * @When I fill form for edit user with username :username, password :password, a confirme password :confirmPassword, email :email and roles :roles
     */
    public function iFillFormForEditUserWithUsernamePasswordAConfirmePasswordEmailAndRoles(?string $username, ?string $password, ?string $confirmPassword, ?string $email, ?string $roles)
    {
        $this->fillField("user_edit[username]", $username);
        $this->fillField("user_edit[newPassword][first]", $password);
        $this->fillField("user_edit[newPassword][second]", $confirmPassword);
        $this->fillField("user_edit[email]", $email);
        $this->fillField("user_edit[roles]", $roles);
    }
}
