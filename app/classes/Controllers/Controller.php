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

use App\Silex;

/**
 * Class Controller
 * @package App\Controllers
 */
abstract class Controller
{
    /**
     * @var Silex
     */
    protected $app;

    /**
     * Controller constructor.
     * @param Silex $app
     */
    public function __construct(Silex $app)
    {
        $this->app = $app;
    }
}
