<?php
/**
 * Registration controller.
 */

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserData;
use App\Repository\UserDataRepository;
use App\Repository\UserRepository;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * Class RegistrationController.
 *
 * @package App\Controller
 */
class RegistrationController extends AbstractController
{
    /**
     * Register action.
     *
     * @Route(
     *     "/register",
     *     name="app_register"
     * )
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param UserDataRepository           $repository
     * @param UserRepository               $userrepository
     *
     * @return Response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, UserDataRepository $repository, UserRepository $userrepository, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {
        $user = new User();
        $userdata = new UserData();
        $form = $this->createForm(RegistrationFormType::class, $userdata);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $user->setPassword($passwordEncoder->encodePassword(
                    $user,
                    $form->get('user')->get('password')->getData()
                ));
                $user->setEmail($form->get('user')->get('email')->getData());
                $user->setUserData($userdata);
                $user->setRoles(['ROLE_USER']);
                $userrepository->save($user);
                $repository->save($userdata);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($userdata);
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'message.registered_successfully');

                return $guardHandler->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $authenticator,
                    'main' // firewall name in security.yaml
                );
            }
        }
//        $user = new User();
//        $form = $this->createForm(RegistrationFormType::class, $user);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            // encode the plain password
//            $user->setPassword(
//                $passwordEncoder->encodePassword(
//                    $user,
//                    $form->get('plainPassword')->getData()
//                )
//            );
//
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($user);
//            $entityManager->flush();
//
//            // do anything else you need here, like send an email
//
//            return $guardHandler->authenticateUserAndHandleSuccess(
//                $user,
//                $request,
//                $authenticator,
//                'main' // firewall name in security.yaml
//            );
//        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
