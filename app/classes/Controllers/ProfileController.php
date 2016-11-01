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

use App\Forms\UpdateProfileModel;
use App\Forms\UpdateProfileType;
use App\Models\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ProfileController
 * @package App\Controllers
 */
class ProfileController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        /** @var User $user */
        $user = $this->app['user'];
        $data = new UpdateProfileModel();
        $data->name = $user->getName();
        $form = $this->app->form($data, [], UpdateProfileType::class)
            ->setAction($this->app->path('profile'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setName($data->name);
            if ($data->new_password) {
                $user->setPassword($this->app->encodePassword($user, $data->new_password));
            }
            $this->app->getEntityManager()->persist($user);
            $this->app->getEntityManager()->flush();
            $this->app->getFlashBag()->add('success', 'profile_updated');
        }
        $this->app->addBreadcrumbItem('profile');
        return $this->app->render('profile.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
