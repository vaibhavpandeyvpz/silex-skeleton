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

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ValidatorTrait
 * @package App\Silex
 */
trait ValidatorTrait
{
    /**
     * @param mixed $value
     * @param Constraint|Constraint[] $constraints
     * @param array|null $groups
     * @return ConstraintViolationListInterface
     */
    public function validate($value, $constraints = null, $groups = null)
    {
        return $this['validator']->validate($value, $constraints, $groups);
    }
}
