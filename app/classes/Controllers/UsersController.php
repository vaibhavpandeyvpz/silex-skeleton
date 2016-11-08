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

use App\Forms\AddEditUserModel;
use App\Forms\AddEditUserType;
use App\Models\User;
use Doctrine\DataTables;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class UsersController
 * @package App\Controllers
 */
class UsersController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request)
    {
        $form = $this->app->form(null, [ 'translator' => $this->app['translator'] ], AddEditUserType::class)
            ->setAction($this->app->path('users_add'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var AddEditUserModel $data */
            $data = $form->getData();
            $user = User::createNew();
            $user->setName($data->name);
            $user->setEmail($data->email);
            $user->setPassword($this->app->encodePassword($user, $data->password));
            $user->setConfirmed($data->is_confirmed);
            $user->setEnabled($data->is_enabled);
            $user->setLocked($data->is_locked);
            $user->setRoles($data->roles);
            $this->app->getEntityManager()->persist($user);
            try {
                $this->app->getEntityManager()->flush();
                $this->app->getFlashBag()->add('success', $this->app->trans('user_added', [ '%name%' => $data->name ], 'flash'));
                return $this->app->redirect($this->app->url('users'));
            } catch (UniqueConstraintViolationException $e) {
                $form->get('email')->addError(
                    new FormError($this->app->trans('email_already_registered', [], 'validators'))
                );
            }
        }
        $this->app->addBreadcrumbItem($this->app->transChoice('users', 2), 'users');
        $this->app->addBreadcrumbItem('add');
        return $this->app->render('add_edit_form.html.twig', [
            'form' => $form->createView(),
            'title' => 'add_user',
        ]);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function deleteAction($id)
    {
        $user = $this->app->getRepository(User::class)->find($id);
        if (is_null($user)) {
            throw new NotFoundHttpException();
        }
        $this->app->getEntityManager()->remove($user);
        $this->app->getEntityManager()->flush();
        $this->app->getFlashBag()->add('success', $this->app->trans('user_deleted', [ '%name%' => $user->getName() ], 'flash'));
        return $this->app->redirect($this->app->url('users'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function editAction(Request $request, $id)
    {
        /** @var User $user */
        $user = $this->app->getRepository(User::class)->find($id);
        if (is_null($user)) {
            throw new NotFoundHttpException();
        }
        $data = new AddEditUserModel();
        $data->name = $user->getName();
        $data->email = $user->getEmail();
        $data->roles = $user->getRoles();
        $data->is_confirmed = $user->isConfirmed();
        $data->is_enabled = $user->isEnabled();
        $data->is_locked = $user->isLocked();
        $options = [
            'translator' => $this->app['translator'],
            'require_password' => false,
            'submit_label' => 'update',
        ];
        $form = $this->app->form($data, $options, AddEditUserType::class)
            ->setAction($this->app->path('users_edit', [ 'id' => $id ]))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setName($data->name);
            $user->setEmail($data->email);
            if ($data->password) {
                $user->setPassword($this->app->encodePassword($user, $data->password));
            }
            $user->setConfirmed($data->is_confirmed);
            $user->setEnabled($data->is_enabled);
            $user->setLocked($data->is_locked);
            $user->setRoles($data->roles);
            $this->app->getEntityManager()->persist($user);
            try {
                $this->app->getEntityManager()->flush();
                $this->app->getFlashBag()->add('success', $this->app->trans('user_updated', [ '%name%' => $data->name ], 'flash'));
                return $this->app->redirect($this->app->url('users'));
            } catch (UniqueConstraintViolationException $e) {
                $form->get('email')->addError(
                    new FormError($this->app->trans('email_already_registered', [], 'validators'))
                );
            }
        }
        $this->app->addBreadcrumbItem($this->app->transChoice('users', 2), 'users');
        $this->app->addBreadcrumbItem('edit');
        return $this->app->render('add_edit_form.html.twig', [
            'form' => $form->createView(),
            'title' => 'edit_user',
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function gridAction(Request $request)
    {
        return $this->app->json(
            (new DataTables\Builder())
                ->withColumnAliases([
                    'id' => 'u.id',
                    'name' => 'u.name',
                    'email' => 'u.email',
                    'roles' => 'u.roles',
                    'isConfirmed' => 'u.isConfirmed',
                    'isEnabled' => 'u.isEnabled',
                    'isLocked' => 'u.isLocked',
                    'createdAt' => 'u.createdAt',
                    'updatedAt' => 'u.updatedAt',
                ])
                ->withIndexColumn('u.id')
                ->withQueryBuilder(
                    $this->app->getEntityManager()
                        ->createQueryBuilder()
                        ->select('u')
                        ->from(User::class, 'u'))
                ->withRequestParams($request->query->all())
                ->getResponse()
        );
    }

    /**
     * @return Response
     */
    public function indexAction()
    {
        $this->app->addBreadcrumbItem($this->app->transChoice('users', 2));
        return $this->app->render('users.html.twig');
    }
}
