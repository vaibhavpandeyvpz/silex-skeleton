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

use App\Controllers\AccountController;
use App\Controllers\DashboardController;
use App\Controllers\HomeController;
use App\Controllers\OAuth2Controller;
use App\Controllers\ProfileController;
use App\Controllers\UsersController;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ControllersServiceProvider
 * @package App\Provider
 */
class ControllersServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        $app['AccountController'] = function ($app) {
            return new AccountController($app);
        };
        $app['DashboardController'] = function ($app) {
            return new DashboardController($app);
        };
        $app['HomeController'] = function ($app) {
            return new HomeController($app);
        };
        $app['OAuth2Controller'] = function ($app) {
            return new OAuth2Controller($app);
        };
        $app['ProfileController'] = function ($app) {
            return new ProfileController($app);
        };
        $app['UsersController'] = function ($app) {
            return new UsersController($app);
        };
    }
}
