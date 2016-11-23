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

use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PasswordResetToken
 * @package App\Models
 * @ORM\Entity
 * @ORM\Table(name="password_reset_tokens")
 */
class PasswordResetToken extends Model
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
     * @ORM\Column(name="is_consumed", type="boolean")
     * @var bool
     */
    protected $isConsumed;

    /**
     * @ORM\Column(name="expires_at", type="datetime")
     * @var \DateTime
     */
    protected $expiresAt;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="passwordResetTokens")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var User
     */
    protected $user;

    /**
     * @return static
     */
    public static function createNew()
    {
        $passwordResetToken = new static();
        $passwordResetToken->setToken(str_random(32));
        $passwordResetToken->setConsumed(false);
        $passwordResetToken->setCreatedAt(new \DateTime());
        $passwordResetToken->setExpiresAt(Carbon::now()->addDay());
        return $passwordResetToken;
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
     * @return \DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @param \DateTime $timestamp
     */
    public function setExpiresAt(\DateTime $timestamp)
    {
        $this->expiresAt = $timestamp;
    }

    /**
     * @return bool
     */
    public function isExpired()
    {
        return $this->getExpiresAt() < new \DateTime();
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
