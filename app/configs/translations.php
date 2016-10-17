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
    'translator.cache_dir' => __DIR__ . '/../storage/translations',
    'translator.resources' => [
        [ 'php', __DIR__ . '/../translations/en/messages.php', 'en', null ],
        [ 'php', __DIR__ . '/../translations/en/emails.php', 'en', 'emails' ],
        [ 'php', __DIR__ . '/../translations/en/flash.php', 'en', 'flash' ],
        [ 'php', __DIR__ . '/../translations/en/validators.php', 'en', 'validators' ],
    ],
];
