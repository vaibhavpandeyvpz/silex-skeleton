<?php

/*
 * This file is part of vaibhavpandeyvpz/silex-skeleton package.
 *
 * (c) Vaibhav Pandey <contact@vaibhavpandey.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.md.
 */

namespace App\Silex;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class SessionTrait
 * @package App\Silex
 */
trait SessionTrait
{
    /**
     * @return FlashBagInterface
     */
    public function getFlashBag()
    {
        return $this->getSession()->getFlashBag();
    }

    /**
     * @return SessionInterface
     */
    public function getSession()
    {
        return $this['session'];
    }
}
