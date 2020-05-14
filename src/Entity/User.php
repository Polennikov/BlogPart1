<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $NameUser;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $AddresUser;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $PhoneUser;

    private $PlainPassword;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->NameUser;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = "ROLE_USER";

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNameUser(): ?string
    {
        return $this->NameUser;
    }

    public function setNameUser(string $NameUser): self
    {
        $this->NameUser = $NameUser;

        return $this;
    }

    public function getAddresUser(): ?string
    {
        return $this->AddresUser;
    }

    public function setAddresUser(string $AddresUser): self
    {
        $this->AddresUser = $AddresUser;

        return $this;
    }

    public function getPhoneUser(): ?string
    {
        return $this->PhoneUser;
    }

    public function setPhoneUser(string $PhoneUser): self
    {
        $this->PhoneUser = $PhoneUser;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->PlainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->PlainPassword = $password;
    }
}
