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

use Swift_Message;

/**
 * Class SwiftmailerTrait
 * @package App\Silex
 */
trait SwiftmailerTrait
{
    /**
     * @return Swift_Message
     */
    public function createMessage()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return Swift_Message::newInstance()
            ->setFrom([ getenv('EMAIL_FROM_EMAIL') => getenv('EMAIL_FROM_NAME') ]);
    }
}
