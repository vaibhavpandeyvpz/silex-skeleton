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
    'swiftmailer.options' => [
        'host' => 'smtp.mailgun.org',
        'port' => 587,
        'username' => getenv('MAILGUN_SMTP_LOGIN'),
        'password' => getenv('MAILGUN_SMTP_PASSWORD'),
        'encryption' => 'tls',
        'auth_mode' => 'login',
    ],
];
