<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table
 * @UniqueEntity("title")
 */
class Task
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(
     *      message="Vous devez saisir un titre."
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(
     *      message="Vous devez saisir du contenu."
     * )
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDone;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    public function __construct()
    {
        $this->createdAt = new \Datetime();
        $this->isDone = false;
    }
    
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
     * getCreatedAt
     *
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
    
    /**
     * setCreatedAt
     *
     * @param  DateTimeInterface $createdAt
     * @return self
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
    
    /**
     * getTitle
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }
    
    /**
     * setTitle
     *
     * @param  string $title
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
    
    /**
     * getContent
     *
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }
    
    /**
     * setContent
     *
     * @param  string $content
     * @return self
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
    
    /**
     * isDone
     *
     * @return bool
     */
    public function isDone(): bool
    {
        return $this->isDone;
    }
    
    /**
     * toggle
     *
     * @param  bool $flag
     * @return bool
     */
    public function toggle(bool $flag): self
    {
        $this->isDone = $flag;

        return $this;
    }
    
    /**
     * getUser
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        //Si la tâche n'a pas d'author alors on lui associe un utilisateur Anonyme
        if (!$this->user) {
            return (new User)->setUsername('Anonyme');
        }

        return $this->user;
    }
    
    /**
     * setUser
     *
     * @param  User|null $user
     * @return self
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
