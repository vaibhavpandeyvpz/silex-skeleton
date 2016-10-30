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

use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;

/**
 * Class AppControllerProvider
 * @package App\Provider
 */
class AppControllerProvider implements ControllerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];
        $controllers->get('/', 'DashboardController:indexAction')
            ->bind('dashboard');
        $controllers->get('/users', 'UsersController:indexAction')
            ->bind('users');
        $controllers->get('/users/add', 'UsersController:addAction')
            ->bind('users_add');
        $controllers->post('/users/add', 'UsersController:addAction');
        $controllers->get('/users/grid', 'UsersController:gridAction');
        $controllers->get('/users/{id}/delete', 'UsersController:deleteAction');
        $controllers->get('/users/{id}/edit', 'UsersController:editAction')
            ->bind('users_edit');
        $controllers->post('/users/{id}/edit', 'UsersController:editAction');
        return $controllers;
    }
}
