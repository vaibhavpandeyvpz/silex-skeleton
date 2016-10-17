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
 * Class LoginHistory
 * @package App\Models
 * @ORM\Entity
 * @ORM\Table(name="login_history")
 */
class LoginHistory extends Model
{
    /**
     * @ORM\Column(name="user_id", type="integer")
     * @var int
     */
    protected $userId;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $browser;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $os;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $device;

    /**
     * @ORM\Column(name="ip_address", type="string")
     * @var string
     */
    protected $ipAddress;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="loginHistory")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var User
     */
    protected $user;

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
    public function getBrowser()
    {
        return $this->browser;
    }

    /**
     * @param string $browser
     */
    public function setBrowser($browser)
    {
        $this->browser = $browser;
    }

    /**
     * @return string
     */
    public function getOS()
    {
        return $this->os;
    }

    /**
     * @param string $os
     */
    public function setOS($os)
    {
        $this->os = $os;
    }

    /**
     * @return string
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * @param string $device
     */
    public function setDevice($device)
    {
        $this->device = $device;
    }

    /**
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * @param string $ip
     */
    public function setIpAddress($ip)
    {
        $this->ipAddress = $ip;
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
