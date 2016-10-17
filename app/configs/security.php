<?php

/*
 * This file is part of vaibhavpandeyvpz/silex-skeleton package.
 *
 * (c) Vaibhav Pandey <contact@vaibhavpandey.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.md.
 */

return [
    'security.access_rules' => [
        [ '^/app/users/', 'ROLE_ADMIN' ],
        [ '^/app/', 'ROLE_USER' ],
    ],
    'security.authentication.logout_handler.app' => function ($app) {
        $handler = new App\Security\LogoutSuccessHandler(
            $app['security.http_utils'],
            $app['security.firewalls']['app']['logout']['target_url']
        );
        $handler->setContainer($app);
        return $handler;
    },
    'security.authentication.success_handler.app' => function ($app) {
        $handler = new App\Security\AuthenticationSuccessHandler(
            $app['security.http_utils'],
            $app['security.firewalls']['app']['form']
        );
        $handler->setContainer($app);
        $handler->setProviderKey('app');
        return $handler;
    },
    'security.firewalls' => [
        'app' => [
            'form' => [
                'check_path' => '/app/login',
                'login_path' => '/login',
                'always_use_default_target_path' => true,
                'default_target_path' => '/app/'
            ],
            'logout' => [
                'invalidate_session' => false,
                'logout_path' => '/app/logout',
                'target_url' => '/login'
            ],
            'pattern' => '^/app/',
            'remember_me' => [ 'key' => getenv('SECURITY_KEY') ],
            'users' => function ($app) {
                return new App\Security\UserProvider($app['em']);
            },
        ],
    ],
    'security.role_hierarchy' => [
        'ROLE_ADMIN' => [ 'ROLE_USER', 'ROLE_ALLOWED_TO_SWITCH' ]
    ],
];
