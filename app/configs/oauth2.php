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
    'oauth2.firewall' => 'app',
    'oauth2.target' => '/app/',
    'oauth2.facebook.options' => [
        'clientId' => getenv('OAUTH2_FACEBOOK_CLIENT_ID'),
        'clientSecret' => getenv('OAUTH2_FACEBOOK_CLIENT_SECRET'),
    ],
    'oauth2.google.options' => [
        'clientId' => getenv('OAUTH2_GOOGLE_CLIENT_ID'),
        'clientSecret' => getenv('OAUTH2_GOOGLE_CLIENT_SECRET'),
    ],
];
