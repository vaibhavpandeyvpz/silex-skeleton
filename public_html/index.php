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

(new Dotenv\Dotenv(__DIR__ . '/../'))
    ->load();

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
    ->register(new App\Provider\TranslationServiceProvider());

// </editor-fold>

// <editor-fold desc="Configuration">

$app->register(new Pimple\Provider\ConfigServiceProvider(__DIR__ . '/../app/configs/app.php'))
    ->register(new Pimple\Provider\ConfigServiceProvider(__DIR__ . '/../app/configs/assets.php'))
    ->register(new Pimple\Provider\ConfigServiceProvider(__DIR__ . '/../app/configs/database.php'))
    ->register(new Pimple\Provider\ConfigServiceProvider(__DIR__ . '/../app/configs/logging.php'))
    ->register(new Pimple\Provider\ConfigServiceProvider(__DIR__ . '/../app/configs/mail.php'))
    ->register(new Pimple\Provider\ConfigServiceProvider(__DIR__ . '/../app/configs/security.php'))
    ->register(new Pimple\Provider\ConfigServiceProvider(__DIR__ . '/../app/configs/translations.php'))
    ->register(new Pimple\Provider\ConfigServiceProvider(__DIR__ . '/../app/configs/views.php'));

if (getenv('APP_ENV') == 'debug') {
    $app->register(new Pimple\Provider\ConfigServiceProvider(__DIR__ . '/../app/configs/app.dev.php', true));
}

// </editor-fold>

// <editor-fold desc="Routes">

$app->get('/', function () use ($app) {
    return $app->redirect($app->url('dashboard'));
});

$app->get('/forgot-password', 'AccountController:forgotPasswordAction')
    ->bind('forgot_password');

$app->post('/forgot-password', 'AccountController:forgotPasswordAction');

$app->get('/login', 'AccountController:loginAction')
    ->bind('login');

$app->get('/reset-password/{token}', 'AccountController:resetPasswordAction')
    ->bind('reset_password');

$app->post('/reset-password/{token}', 'AccountController:resetPasswordAction');

//$app->get('/register', function () use ($app) {
//    $user = App\Models\User::createNew();
//    $user->setEmail('name@example.tld');
//    $user->setName('Your Name');
//    $user->setPassword($app->encodePassword($user, '12345678'));
//    $app->getEntityManager()->persist($user);
//    $app->getEntityManager()->flush();
//});

$app->mount('/app', new App\Provider\AppControllerProvider());

$app->before(function () use ($app) {
    $app->addBreadcrumbItem('app', 'dashboard');
});

// </editor-fold>

$app->run();
