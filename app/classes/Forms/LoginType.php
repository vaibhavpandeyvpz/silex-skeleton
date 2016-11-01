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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class LoginType
 * @package App\Forms
 */
class LoginType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('_username', EmailType::class, [
            'attr' => [ 'autofocus' => 'autofocus' ],
            'label' => 'email',
        ]);
        $builder->add('_password', PasswordType::class, [ 'label' => 'password' ]);
        $builder->add('_remember_me', CheckboxType::class, [
            'label' => 'remember_me',
            'required' => false,
        ]);
        $builder->add('submit', SubmitType::class, [
            'attr' => [ 'class' => 'btn btn-success' ],
            'label' => 'login',
        ]);
        $builder->setMethod('POST');
    }
}
