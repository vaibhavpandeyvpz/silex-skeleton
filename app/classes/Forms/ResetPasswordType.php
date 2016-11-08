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
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ResetPasswordType
 * @package App\Forms
 */
class ResetPasswordType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('new_password', RepeatedType::class, [
            'invalid_message' => 'passwords_mismatch',
            'first_options'  => [
                'attr' => [ 'autofocus' => 'autofocus' ],
                'label' => 'new_password',
            ],
            'second_options' => [ 'label' => 'confirm_password' ],
            'type' => PasswordType::class,
        ]);
        $builder->add('submit', SubmitType::class, [
            'attr' => [ 'class' => 'btn btn-success' ],
            'label' => 'reset_password',
        ]);
        $builder->setMethod('POST');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([ 'data_class' => ResetPasswordModel::class ]);
    }
}
