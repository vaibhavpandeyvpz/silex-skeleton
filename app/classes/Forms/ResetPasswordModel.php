<?php

/*
 * This file is part of vaibhavpandeyvpz/silex-skeleton package.
 *
 * (c) Vaibhav Pandey <contact@vaibhavpandey.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.md.
 */

namespace App\Forms;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ResetPasswordModel
 * @package App\Forms
 */
class ResetPasswordModel
{
    /**
     * @var string
     */
    public $new_password;

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('new_password', [
            new Assert\Required(),
            new Assert\NotBlank(),
            new Assert\Length([
                'min' => 8,
                'max' => 32,
            ]),
        ]);
    }
}
