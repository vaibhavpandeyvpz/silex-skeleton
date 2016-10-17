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
    'db.options' => [
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'port' => 3306,
        'user' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
        'dbname' => getenv('DB_NAME'),
        'charset' => 'utf8',
    ],
    'db.fetch_mode' => PDO::FETCH_OBJ,
    'em.cache_path' => __DIR__ . '/../storage/orm/cache',
    'em.models_path' => __DIR__ . '/../../classpath/Models',
    'em.proxy_dir' => __DIR__ . '/../storage/orm/proxies',
    'em.proxy_namespace' => 'App\\Models\\Proxies',
];
