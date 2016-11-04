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
 * Class AddEditUserModel
 * @package App\Forms
 */
class AddEditUserModel
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string[]
     */
    public $roles;

    /**
     * @var bool
     */
    public $is_confirmed;

    /**
     * @var bool
     */
    public $is_enabled;

    /**
     * @var bool
     */
    public $is_locked;

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
        $metadata->addPropertyConstraints('email', [
            new Assert\Required(),
            new Assert\NotBlank(),
            new Assert\Email(),
        ]);
        $metadata->addPropertyConstraint('password', new Assert\Length([
            'min' => 8,
            'max' => 32,
        ]));
        $metadata->addPropertyConstraints('roles', [
            new Assert\Required(),
            new Assert\NotBlank(),
            new Assert\Choice([
                'choices' => [
                    'ROLE_ADMIN',
                    'ROLE_USER',
                ],
                'multiple' => true,
            ]),
        ]);
    }
}
