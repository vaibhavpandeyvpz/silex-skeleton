<?php

/*
 * This file is part of vaibhavpandeyvpz/silex-skeleton package.
 *
 * (c) Vaibhav Pandey <contact@vaibhavpandey.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.md.
 */

namespace App\Models;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Class User
 * @package App\Models
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends Model implements AdvancedUserInterface
{
    /**
     * @ORM\Column(type="string", length=128)
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="string", unique=true, length=128, unique=true)
     * @var string
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=128)
     * @var string
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=16)
     * @var string
     */
    protected $salt;

    /**
     * @ORM\Column(type="simple_array")
     * @var array
     */
    protected $roles;

    /**
     * @ORM\Column(name="is_enabled", type="boolean")
     * @var bool
     */
    protected $isEnabled;

    /**
     * @ORM\Column(name="is_locked", type="boolean")
     * @var bool
     */
    protected $isLocked;

    /**
     * @ORM\OneToMany(targetEntity="EmailConfirmationToken", mappedBy="user", cascade={"persist"})
     * @var ArrayCollection
     */
    protected $emailConfirmationTokens;

    /**
     * @ORM\OneToMany(targetEntity="LoginHistory", mappedBy="user", cascade={"persist"})
     * @ORM\OrderBy({"createdAt" = "DESC"})
     * @var ArrayCollection
     */
    protected $loginHistory;

    /**
     * @ORM\OneToMany(targetEntity="PasswordResetToken", mappedBy="user", cascade={"persist"})
     * @var ArrayCollection
     */
    protected $passwordResetTokens;

    public function __construct()
    {
        $this->emailConfirmationTokens = new ArrayCollection();
        $this->loginHistory = new ArrayCollection();
        $this->passwordResetTokens = new ArrayCollection();
    }

    /**
     * @return static
     */
    public static function createNew()
    {
        $user = new static();
        $user->setRoles('ROLE_USER');
        $user->setSalt(str_random(16));
        $user->setEnabled(false);
        $user->setLocked(false);
        $user->setCreatedAt(new DateTime());
        return $user;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param array|string $roles
     */
    public function setRoles($roles)
    {
        $this->roles = (array)$roles;
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * @param bool $isEnabled
     */
    public function setEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;
    }

    /**
     * @return boolean
     */
    public function isLocked()
    {
        return $this->isLocked;
    }

    /**
     * @param boolean $isLocked
     */
    public function setLocked($isLocked)
    {
        $this->isLocked = $isLocked;
    }

    /**
     * @return ArrayCollection
     */
    public function getEmailConfirmationTokens()
    {
        return $this->emailConfirmationTokens;
    }

    /**
     * @param EmailConfirmationToken $emailConfirmationToken
     */
    public function addEmailConfirmationToken(EmailConfirmationToken $emailConfirmationToken)
    {
        $this->emailConfirmationTokens[] = $emailConfirmationToken;
        $emailConfirmationToken->setUser($this);
    }

    /**
     * @return ArrayCollection
     */
    public function getLoginHistory()
    {
        return $this->loginHistory;
    }

    /**
     * @param LoginHistory $loginHistory
     */
    public function addLoginHistory(LoginHistory $loginHistory)
    {
        $this->loginHistory[] = $loginHistory;
        $loginHistory->setUser($this);
    }

    /**
     * @return ArrayCollection
     */
    public function getPasswordResetTokens()
    {
        return $this->passwordResetTokens;
    }

    /**
     * @param PasswordResetToken $passwordResetToken
     */
    public function addPasswordResetToken(PasswordResetToken $passwordResetToken)
    {
        $this->passwordResetTokens[] = $passwordResetToken;
        $passwordResetToken->setUser($this);
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonLocked()
    {
        return !$this->isLocked();
    }

    /**
     * {@inheritdoc}
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
    }
}
