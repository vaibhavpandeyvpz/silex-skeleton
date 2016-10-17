<?php

/*
 * This file is part of vaibhavpandeyvpz/silex-skeleton package.
 *
 * (c) Vaibhav Pandey <contact@vaibhavpandey.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.md.
 */

namespace App\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Translation\Loader\PhpFileLoader;
use Symfony\Component\Translation\Translator;

/**
 * Class TranslationServiceProvider
 * @package App\Provider
 */
class TranslationServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        $app->extend('translator', function (Translator $translator) {
            $translator->addLoader('php', new PhpFileLoader());
            return $translator;
        });
    }
}
