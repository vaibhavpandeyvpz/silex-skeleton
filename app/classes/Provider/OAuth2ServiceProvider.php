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

use League\OAuth2\Client\Provider\Facebook;
use League\OAuth2\Client\Provider\Google;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class OAuth2ServiceProvider
 * @package App\Provider
 */
class OAuth2ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        $app['oauth2.facebook'] = function ($app) {
            /** @var \App\Silex $app */
            $options = array_replace([
                'graphApiVersion' => 'v2.8',
                'redirectUri' => $app->url('oauth2_response', [ 'server' => 'facebook' ]),
            ], $app['oauth2.facebook.options']);
            return new Facebook($options);
        };
        $app['oauth2.google'] = function ($app) {
            /** @var \App\Silex $app */
            $options = array_replace([
                'redirectUri' => $app->url('oauth2_response', [ 'server' => 'google' ]),
            ], $app['oauth2.google.options']);
            return new Google($options);
        };
    }
}
