<?php
/**
 * Registration controller.
 */

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserData;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use App\Service\RegistrationService;
use App\Service\UserDataService;
use App\Service\UserService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

/**
 * Class RegistrationController.
 */
class RegistrationController extends AbstractController
{
    /**
     * Registration service.
     *
     * @var \App\Service\RegistrationService
     */
    private $registrationService;

    /**
     * User data service.
     *
     * @var \App\Service\UserDataService
     */
    private $userDataService;

    /**
     * User service.
     *
     * @var \App\Service\UserService
     */
    private $userService;

    /**
     * RegistrationController constructor.
     *
     * @param \App\Service\RegistrationService $registrationService Registration service
     * @param \App\Service\UserDataService     $userDataService     User data service
     * @param \App\Service\UserService         $userService         User service
     */
    public function __construct(RegistrationService $registrationService, UserDataService $userDataService, UserService $userService)
    {
        $this->registrationService = $registrationService;
        $this->userDataService = $userDataService;
        $this->userService = $userService;
    }

    /**
     * Register action.
     *
     * @param Request                   $request
     * @param GuardAuthenticatorHandler $guardHandler
     * @param LoginFormAuthenticator    $authenticator
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @return Response
     *
     * @Route(
     *     "/register",
     *     name="app_register"
     * )
     */
    public function register(Request $request, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('recipe_index');
        }

        $user = new User();
        $userdata = new UserData();
        $form = $this->createForm(RegistrationFormType::class, $user);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $user->setPassword(
                    $this->registrationService->encodingPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );

                $user->setUserData($userdata);
                $userdata->setFirstName($form->get('userdata')->get('firstName')->getData());
                $userdata->setLastName($form->get('userdata')->get('lastName')->getData());
                $userdata->setNick($form->get('userdata')->get('nick')->getData());
                $user->setRoles(['ROLE_USER']);
                $this->userService->save($user);
                $this->userDataService->save($userdata);

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

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
