<?php
/**
 * Security controller.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends AbstractController
{
    /**
     * Login form action.
     *
     * @param \Symfony\Component\Security\Http\Authentication\AuthenticationUtils $authenticationUtils Auth utils
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/login",
     *     name="app_login"
     * )
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        if($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('recipe_index');
        };

        return $this->render(
            'security/login.html.twig',
            [
                'last_username' => $lastUsername,
                'error' => $error
            ]
        );
    }

    /**
     * Logout action.
     *
     * @throws \Exception
     *
     * @Route(
     *     "/logout",
     *     name="app_logout"
     * )
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
