<?php

/*
 * This file is part of vaibhavpandeyvpz/silex-skeleton package.
 *
 * (c) Vaibhav Pandey <contact@vaibhavpandey.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.md.
 */

namespace App;

use Pimple\Breadcrumbs\BreadcrumbsTrait;
use Silex\Application;

/**
 * Class App
 * @package Silex
 */
class Silex extends Application
{
    use Application\FormTrait;
    use Application\MonologTrait;
    use Application\SecurityTrait;
    use Application\SwiftmailerTrait;
    use Application\UrlGeneratorTrait;
    use Application\TranslationTrait;
    use Application\TwigTrait;
    use BreadcrumbsTrait;
    use Silex\DoctrineTrait;
    use Silex\SessionTrait;
    use Silex\SwiftmailerTrait;
    use Silex\ValidatorTrait;
}
