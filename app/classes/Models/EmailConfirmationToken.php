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

use Doctrine\ORM\Mapping as ORM;

/**
 * Class EmailConfirmationToken
 * @package App\Models
 * @ORM\Entity
 * @ORM\Table(name="email_confirmation_tokens")
 */
class EmailConfirmationToken extends Model
{
    /**
     * @ORM\Column(name="user_id", type="integer")
     * @var int
     */
    protected $userId;

    /**
     * @ORM\Column(type="string", length=32, unique=true)
     * @var string
     */
    protected $token;

    /**
     * @ORM\Column(name="email_hash", type="string", length=32, unique=true)
     * @var string
     */
    protected $emailHash;

    /**
     * @ORM\Column(name="is_consumed", type="boolean")
     * @var bool
     */
    protected $isConsumed;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="emailConfirmationTokens")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var User
     */
    protected $user;

    /**
     * @return static
     */
    public static function createNew()
    {
        $emailConfirmationToken = new static();
        $emailConfirmationToken->setToken(str_random(32));
        $emailConfirmationToken->setConsumed(false);
        $emailConfirmationToken->setCreatedAt(new \DateTime());
        return $emailConfirmationToken;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getEmailHash()
    {
        return $this->emailHash;
    }

    /**
     * @param string $emailHash
     */
    public function setEmailHash($emailHash)
    {
        $this->emailHash = $emailHash;
    }

    /**
     * @return bool
     */
    public function isConsumed()
    {
        return $this->isConsumed;
    }

    /**
     * @param bool $consumed
     */
    public function setConsumed($consumed)
    {
        $this->isConsumed = $consumed;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }
}
