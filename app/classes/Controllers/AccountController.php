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

use DateTime;
use App\Forms\ForgotPasswordModel;
use App\Forms\ForgotPasswordType;
use App\Forms\LoginType;
use App\Forms\ResetPasswordModel;
use App\Forms\ResetPasswordType;
use App\Models\PasswordResetToken;
use App\Models\User;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AccountController
 * @package App\Controllers
 */
class AccountController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function forgotPasswordAction(Request $request)
    {
        $form = $this->app->form(null, [], ForgotPasswordType::class)
            ->setAction($this->app->path('forgot_password'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ForgotPasswordModel $data */
            $data = $form->getData();
            $user = $this->app->getRepository(User::class)
                ->findOneBy([ 'email' => $data->email ]);
            if (is_null($user)) {
                $form->get('email')->addError(
                    new FormError($this->app->trans('email_not_found', [], 'validators'))
                );
            } else {
                /** @var User $user */
                $passwordResetToken = PasswordResetToken::createNew();
                $passwordResetToken->setUser($user);
                $this->app->getEntityManager()->persist($passwordResetToken);
                $this->app->getEntityManager()->flush();
                /** @noinspection PhpParamsInspection */
                $this->app->mail(
                    $this->app->createMessage()
                        ->setTo([ $user->getEmail() => $user->getName() ])
                        ->setSubject($this->app->trans('forgot_password_subject', [ '%app%' => $this->app->trans('app') ], 'emails'))
                        ->setContentType('text/html')
                        ->setBody($this->app->renderView('emails/forgot_password.html.twig', [
                            'link' => $this->app->url('reset_password', [ 'token' => $passwordResetToken->getToken() ])
                        ]))
                );
                return $this->app->render('forgot_password_confirmation.html.twig', [
                    'form' => $form->createView(),
                    'email' => $user->getEmail(),
                ]);
            }
        }
        return $this->app->render('forgot_password.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function loginAction(Request $request)
    {
        $form = $this->app->namedForm(null, null, [], LoginType::class)
            ->setAction($this->app->path('app_login'))
            ->getForm();
        if ($e = $this->app['security.last_error']($request)) {
            $this->app->getFlashBag()->add('danger', $e);
        }
        return $this->app->render('login.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param string $token
     * @return Response
     */
    public function resetPasswordAction(Request $request, $token)
    {
        $form = $this->app->form(null, [], ResetPasswordType::class)
            ->setAction($this->app->path('reset_password', [ 'token' => $token ]))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $this->app->validate($token, [
                new Assert\NotBlank(),
                new Assert\Length(32)
            ]);
            if (count($errors) >= 1) {
                throw new BadRequestHttpException();
            }
            /** @var ResetPasswordModel $data */
            $data = $form->getData();
            /** @var PasswordResetToken $passwordResetToken */
            $passwordResetToken = $this->app->getRepository(PasswordResetToken::class)
                ->findOneBy([
                    'isConsumed' => false,
                    'token' => $token,
                ]);
            if (is_null($passwordResetToken) || ($passwordResetToken->getExpiresAt() < new DateTime())) {
                throw new NotFoundHttpException();
            }
            $passwordResetToken->setConsumed(true);
            $passwordResetToken->getUser()->setPassword(
                $this->app->encodePassword($passwordResetToken->getUser(), $data->new_password)
            );
            $this->app->getEntityManager()->persist($passwordResetToken);
            $this->app->getEntityManager()->flush();
            $this->app->getFlashBag()->add('success', 'password_updated');
            return $this->app->redirect($this->app->url('login'));
        }
        return $this->app->render('reset_password.html.twig', [
            'form' => $form->createView(),
            'token' => $token,
        ]);
    }
}
