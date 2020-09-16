<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table("user")
 * @ORM\Entity
 * @UniqueEntity("email")
 */
class User implements UserInterface
{
    const ROLES = [ 
        'Utilisateur' => 'ROLE_USER', 
        'Administrateur' => 'ROLE_ADMIN'
    ];

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank(
     *      message="Vous devez saisir un nom d'utilisateur."
     * )
     * 
     * @Assert\Length(
     *      max = 25,
     *      maxMessage = "Votre pseudo ne peut contenir plus de {{ limit }} caractères"
     * )
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank(
     *      message="Vous devez saisir un mot de passe."
     * )
     * 
     * @Assert\Regex(
     *     pattern="/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{6,}$/",
     *     message="Votre mot de passe n'est pas au bon format. Il doit contenir au moins une majuscule, une minuscule et un nombre et avoir six 6 caractères au minimum"
     * )
     */
    private $password;

    private $newPassword;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\NotBlank(
     *      message="Vous devez saisir une adresse email."
     * )
     * 
     * @Assert\Email(
     *      message="Le format de l'adresse n'est pas correcte."
     * )
     * 
     * @Assert\Length(
     *      max = 60,
     *      maxMessage = "Votre email ne peut contenir plus de {{ limit }} caractères"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];
    
    /**
     * getId
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     * @return string
     */
    public function getUsername(): ?string
    {
        return (string) $this->username;
    }
    
    /**
     * setUsername
     *
     * @param  string $username
     * @return self
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }
        
    /**
     * getSalt
     * 
     * @see UserInterface
     */
    public function getSalt()
    {
        return null;
    }
    
    /**
     * getPassword
     *
     * @see UserInterface
     * @return string
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }
    
    /**
     * setPassword
     *
     * @param  string $password
     * @return string
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    
    /**
     * getEmail
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }
    
    /**
     * setEmail
     *
     * @param  string $email
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @see UserInterface
     * @return array
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * setRoles
     *
     * @param  array $roles
     * @return self
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
    
    /**
     * eraseCredentials
     * 
     * @see UserInterface
     */
    public function eraseCredentials()
    {
    }

    /**
     * Get the value of newPassword
     */ 
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * Set the value of newPassword
     *
     * @return  self
     */ 
    public function setNewPassword($newPassword)
    {
        $this->newPassword = $newPassword;

        return $this;
    }
}
