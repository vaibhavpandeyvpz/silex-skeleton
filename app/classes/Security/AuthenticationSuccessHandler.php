<?php

/*
 * This file is part of vaibhavpandeyvpz/silex-skeleton package.
 *
 * (c) Vaibhav Pandey <contact@vaibhavpandey.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.md.
 */

namespace App\Security;

use App\Models\LoginHistory;
use Pimple\Container;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use UAParser\Parser;

/**
 * Class AuthenticationSuccessHandler
 * @package App\Security
 */
class AuthenticationSuccessHandler extends DefaultAuthenticationSuccessHandler
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @param Container $container
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $user = $token->getUser();
        $ua = Parser::create();
        $ua = $ua->parse($request->headers->get('User-Agent'));
        $history = new LoginHistory();
        $history->setUser($user);
        $history->setBrowser($ua->ua->toString());
        $history->setDevice($ua->device->family);
        $history->setOS($ua->os->toString());
        $history->setIpAddress($request->getClientIp());
        $history->setCreatedAt(new \DateTime());
        $this->container['em']->persist($history);
        $this->container['em']->flush();
        return parent::onAuthenticationSuccess($request, $token);
    }
}
