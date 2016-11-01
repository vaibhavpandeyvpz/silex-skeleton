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
 * Class UpdateProfileModel
 * @package App\Forms
 */
class UpdateProfileModel
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $new_password;

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('name', [
            new Assert\Required(),
            new Assert\NotBlank(),
            new Assert\Length([
                'min' => 2,
                'max' => 128,
            ]),
        ]);
        $metadata->addPropertyConstraints('new_password', [
            new Assert\Length([
                'min' => 8,
                'max' => 32,
            ]),
        ]);
    }
}
