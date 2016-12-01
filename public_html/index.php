<?php

/*
 * This file is part of vaibhavpandeyvpz/silex-skeleton package.
 *
 * (c) Vaibhav Pandey <contact@vaibhavpandey.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.md.
 */

require_once __DIR__ . '/../vendor/autoload.php';

// <editor-fold desc="Environment Variables">

(new Dotenv\Dotenv(__DIR__ . '/../'))->load();

// </editor-fold>

$app = new App\Silex();

// <editor-fold desc="Services">

$app->register(new Silex\Provider\AssetServiceProvider())
    ->register(new Silex\Provider\CsrfServiceProvider())
    ->register(new Silex\Provider\DoctrineServiceProvider())
    ->register(new Silex\Provider\FormServiceProvider())
    ->register(new Silex\Provider\LocaleServiceProvider())
    ->register(new Silex\Provider\MonologServiceProvider())
    ->register(new Silex\Provider\ValidatorServiceProvider())
    ->register(new Silex\Provider\SecurityServiceProvider())
    ->register(new Silex\Provider\RememberMeServiceProvider())
    ->register(new Silex\Provider\ServiceControllerServiceProvider())
    ->register(new Silex\Provider\SessionServiceProvider())
    ->register(new Silex\Provider\SwiftmailerServiceProvider())
    ->register(new Silex\Provider\TranslationServiceProvider())
    ->register(new Silex\Provider\TwigServiceProvider());

$app->register(new Pimple\Breadcrumbs\BreadcrumbsServiceProvider())
    ->register(new App\Provider\ControllersServiceProvider())
    ->register(new App\Provider\DoctrineServiceProvider())
    ->register(new App\Provider\OAuth2ServiceProvider())
    ->register(new App\Provider\TranslationServiceProvider());

// </editor-fold>

// <editor-fold desc="Configuration">

$app->register(new Pimple\Provider\ConfigServiceProvider(__DIR__ . '/../app/configs/app.php'))
    ->register(new Pimple\Provider\ConfigServiceProvider(__DIR__ . '/../app/configs/assets.php'))
    ->register(new Pimple\Provider\ConfigServiceProvider(__DIR__ . '/../app/configs/doctrine.php'))
    ->register(new Pimple\Provider\ConfigServiceProvider(__DIR__ . '/../app/configs/logging.php'))
    ->register(new Pimple\Provider\ConfigServiceProvider(__DIR__ . '/../app/configs/mail.php'))
    ->register(new Pimple\Provider\ConfigServiceProvider(__DIR__ . '/../app/configs/oauth2.php'))
    ->register(new Pimple\Provider\ConfigServiceProvider(__DIR__ . '/../app/configs/security.php'))
    ->register(new Pimple\Provider\ConfigServiceProvider(__DIR__ . '/../app/configs/translations.php'))
    ->register(new Pimple\Provider\ConfigServiceProvider(__DIR__ . '/../app/configs/views.php'));

// </editor-fold>

// <editor-fold desc="Profiler">

if (getenv('APP_ENV') == 'debug') {
    $app->register(new Silex\Provider\HttpFragmentServiceProvider())
        ->register(new Silex\Provider\WebProfilerServiceProvider())
        ->register(new Pimple\Provider\ConfigServiceProvider(__DIR__ . '/../app/configs/profiler.php'));
}

// </editor-fold>

// <editor-fold desc="Routes">

$app->get('/', 'HomeController:indexAction')
    ->bind('home');

$app->get('/confirm-email/{token}', 'AccountController:confirmEmailAction')
    ->bind('confirm_email');

$app->get('/forgot-password', 'AccountController:forgotPasswordAction')
    ->bind('forgot_password');

$app->post('/forgot-password', 'AccountController:forgotPasswordAction');

$app->get('/login', 'AccountController:loginAction')
    ->bind('login');

$app->get('/oauth2/{server}', 'OAuth2Controller:indexAction')
    ->bind('oauth2');

$app->get('/oauth2/{server}/response', 'OAuth2Controller:responseAction')
    ->bind('oauth2_response');

$app->get('/register', 'AccountController:registerAction')
    ->bind('register');

$app->post('/register', 'AccountController:registerAction');

$app->get('/reset-password/{token}', 'AccountController:resetPasswordAction')
    ->bind('reset_password');

$app->post('/reset-password/{token}', 'AccountController:resetPasswordAction');

$app->mount('/app', new App\Provider\AppControllerProvider());

$app->before(function () use ($app) {
    $app->addBreadcrumbItem('app', 'home');
});

// </editor-fold>

$app->run();
