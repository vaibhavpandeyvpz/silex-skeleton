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

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class DoctrineServiceProvider
 * @package App\Provider
 */
class DoctrineServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        $app->extend('db', function (Connection $connection, $app) {
            $connection->setFetchMode($app['db.fetch_mode']);
            return $connection;
        });
        $app['em.cache'] = function ($app) {
            return $app['debug'] ? new ArrayCache() : new FilesystemCache($app['em.cache_path']);
        };
        $app['em.config'] = function ($app) {
            $config = new Configuration();
            $config->setMetadataCacheImpl($app['em.cache']);
            $driver = $config->newDefaultAnnotationDriver($app['em.models_path'], false);
            $config->setMetadataDriverImpl($driver);
            $config->setQueryCacheImpl($app['em.cache']);
            $config->setProxyDir($app['em.proxy_dir']);
            $config->setProxyNamespace($app['em.proxy_namespace']);
            $config->setAutoGenerateProxyClasses(true);
            return $config;
        };
        $app['em'] = function ($app) {
            return EntityManager::create($app['db'], $app['em.config']);
        };
    }
}
