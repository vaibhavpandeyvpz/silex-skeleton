<?php

/*
 * This file is part of vaibhavpandeyvpz/silex-skeleton package.
 *
 * (c) Vaibhav Pandey <contact@vaibhavpandey.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.md.
 */

namespace App\Middleware;

use App\Models\User;
use App\Silex;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ConfirmEmailMiddleware
 * @package App\Middleware
 */
class ConfirmEmailMiddleware
{
    /**
     * @param Request $request
     * @param Application|Silex $app
     */
    public function __invoke(Request $request, Application $app)
    {
        if ($request->isXmlHttpRequest() === false) {
            /** @var User $user */
            $user = $app['user'];
            if (($user instanceof User) && ($user->isConfirmed() !== true)) {
                $app->getFlashBag()->add('warning', $app->trans('confirm_email', [ '%email%' => $user->getEmail() ], 'flash'));
            }
        }
    }
}
