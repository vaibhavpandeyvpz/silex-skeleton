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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class AddEditUserType
 * @package App\Forms
 */
class AddEditUserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var TranslatorInterface $translator */
        $translator = $options['translator'];
        $builder->add('name', TextType::class, [
            'attr' => [ 'autofocus' => 'autofocus' ],
            'label' => 'name',
        ]);
        $builder->add('email', EmailType::class, [ 'label' => 'email' ]);
        $builder->add('password', RepeatedType::class, [
            'invalid_message' => 'passwords_mismatch',
            'first_options'  => [
                'attr' => [ 'autofocus' => 'autofocus' ],
                'label' => 'password',
            ],
            'required' => $options['require_password'],
            'second_options' => [ 'label' => 'confirm_password' ],
            'type' => PasswordType::class,
        ]);
        $builder->add('roles', ChoiceType::class, [
            'attr' => [
                'class' => 'select2-multiple',
                'data-widget' => 'select2',
            ],
            'choices'  => [
                'administrator' => 'ROLE_ADMIN',
                $translator->transChoice('users', 1) => 'ROLE_USER',
            ],
            'label' => 'roles',
            'multiple' => true,
        ]);
        $builder->add('is_enabled', CheckboxType::class, [
            'label' => 'enabled',
            'required' => false,
        ]);
        $builder->add('is_locked', CheckboxType::class, [
            'label' => 'locked',
            'required' => false,
        ]);
        $builder->add('submit', SubmitType::class, [
            'attr' => [ 'class' => 'btn btn-success' ],
            'label' => $options['submit_label'],
        ]);
        $builder->setMethod('POST');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AddEditUserModel::class,
            'require_password' => true,
            'submit_label' => 'add',
        ]);
        $resolver->setRequired('require_password');
        $resolver->setAllowedTypes('require_password', 'bool');
        $resolver->setRequired('submit_label');
        $resolver->setAllowedTypes('submit_label', 'string');
        $resolver->setRequired('translator');
        $resolver->setAllowedTypes('translator', TranslatorInterface::class);
    }
}
