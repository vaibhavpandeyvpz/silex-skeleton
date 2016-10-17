<?php

/*
 * This file is part of vaibhavpandeyvpz/silex-skeleton package.
 *
 * (c) Vaibhav Pandey <contact@vaibhavpandey.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.md.
 */

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class DashboardController
 * @package App\Controllers
 */
class DashboardController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        $this->app->addBreadcrumbItem('dashboard');
        return $this->app->render('dashboard.html.twig');
    }
}
