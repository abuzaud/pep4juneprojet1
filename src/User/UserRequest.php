<?php

namespace App\User;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserRequest
 * @package App\User
 */
class UserRequest
{
    /**
     * @Assert\NotBlank(message="Saisissez votre Prénom")
     * @Assert\Length(max="50", maxMessage="Votre prénom est trop long. {{ limit }} caractères max.")
     */
    private $firstname;

    /**
     * @Assert\NotBlank(message="Saisissez votre Nom")
     * @Assert\Length(max="50", maxMessage="Votre nom est trop long. {{ limit }} caractères max.")
     */
    private $lastname;

    /**
     * @Assert\NotBlank(message="Saisissez votre Email")
     * @Assert\Length(max="80", maxMessage="Votre email est trop long. {{ limit }} caractères max.")
     * @Assert\Email(message="Vérifiez votre email.")
     */
    private $email;

    /**
     * @Assert\NotBlank(message="Saisissez votre Mot de passe")
     * @Assert\Length(
     *     min="8",
     *     minMessage="Votre mot de passe est trop court. {{ limit }} caractères min.",
     *     max="20",
     *     maxMessage="Votre mot de passe est trop long. {{ limit }} caractères max."
     * )
     */
    private $password;

    /**
     * @Assert\IsTrue(message="Vous devez valider nos CGU.")
     */
    private $conditions;
    /**
     * @var \DateTime
     */
    private $registrationDate;
    /**
     * @var
     */
    private $roles;

    /**
     * UserRequest constructor.
     * @param string $role
     * @internal param $roles
     */
    public function __construct()
    {
        $this->registrationDate = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * @return \DateTime
     */
    public function getRegistrationDate(): \DateTime
    {
        return $this->registrationDate;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $firstname
     * @return UserRequest
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @param mixed $lastname
     * @return UserRequest
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @param mixed $email
     * @return UserRequest
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param mixed $password
     * @return UserRequest
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @param mixed $conditions
     * @return UserRequest
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;
        return $this;
    }

    /**
     * @param \DateTime $registrationDate
     * @return UserRequest
     */
    public function setRegistrationDate(\DateTime $registrationDate)
    {
        $this->registrationDate = $registrationDate;
        return $this;
    }

    /**
     * @param mixed $roles
     * @return UserRequest
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
        return $this;
    }


    /**
     * @param string $role
     * @return $this
     */
    public function addRole(string $role)
    {
        $this->roles[] = $role;
        return $this;
    }
}
