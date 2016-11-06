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

use App\Models\User;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\FacebookUser;
use League\OAuth2\Client\Provider\GoogleUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Class OAuth2Controller
 * @package App\Controllers
 */
class OAuth2Controller extends Controller
{
    /**
     * @param string $server
     * @return Response
     */
    public function indexAction($server)
    {
        switch ($server) {
            case 'facebook':
            case 'google':
                /** @var AbstractProvider $provider */
                $provider = $this->app["oauth2.{$server}"];
                break;
            default:
                throw new NotFoundHttpException();
        }
        $url = $provider->getAuthorizationUrl([ 'scope' => [ 'email' ] ]);
        $this->app->getSession()->set("oauth2.{$server}.state", $provider->getState());
        return $this->app->redirect($url);
    }

    /**
     * @param Request $request
     * @param string $server
     * @return Response
     */
    public function responseAction(Request $request, $server)
    {
        switch ($server) {
            case 'facebook':
            case 'google':
                /** @var AbstractProvider $provider */
                $provider = $this->app["oauth2.{$server}"];
                break;
            default:
                throw new NotFoundHttpException();
        }
        $session = $this->app->getSession();
        if (($request->query->has('code') === false) || empty($state = $request->query->get('state'))) {
            throw new NotFoundHttpException();
        } elseif ($state !== $session->get("oauth2.{$server}.state")) {
            throw new BadRequestHttpException();
        }
        $token = $provider->getAccessToken('authorization_code', [ 'code' => $request->query->get('code') ]);
        /** @var FacebookUser|GoogleUser $user */
        $user = $provider->getResourceOwner($token);
        if (empty($email = $user->getEmail())) {
            $this->app->getFlashBag()->add('danger', 'oauth_no_email');
        } elseif ($user = $this->app->getRepository(User::class)->findOneBy([ 'email' => $email ])) {
            /** @var User $user */
            $token = new UsernamePasswordToken($user, null, $this->app['oauth2.firewall'], $user->getRoles());
            $this->app['security.token_storage']->setToken($token);
            $session->set('_security_' . $this->app['oauth2.firewall'], serialize($token));
            // Redirect
            $key = '_security.' . $this->app['oauth2.firewall'] . '.target_path';
            if ($session->has($key)) {
                $path = $session->get($key);
                $session->remove($key);
            } else {
                $path = $this->app['oauth2.default_target_path'];
            }
            $session->save();
            return $this->app->redirect($path);
        } else {
            $this->app->getFlashBag()->add('danger', 'oauth_no_user_found');
        }
        return $this->app->redirect($this->app->url('login'));
    }
}
