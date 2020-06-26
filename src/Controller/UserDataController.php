<?php
/**
 * UserData controller.
 */

namespace App\Controller;

use App\Entity\UserData;
use App\Service\UserDataService;
use App\Form\UserDataType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class UserDataController.
 *
 * @Route("/userdata")
 *
 * @IsGranted("ROLE_USER")
 */
class UserDataController extends AbstractController
{
    /**
     * UserData service.
     *
     * @var \App\Service\UserDataService
     */
    private $userDataService;

    /**
     * UserDataController constructor.
     *
     * @param \App\Service\UserDataService  $userDataService  UserData service
     *
     */
    public function __construct(UserDataService $userDataService)
    {
        $this->userDataService=$userDataService;
    }

    /**
     * Change data action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\UserData $userdata UserData entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="user_edit",
     * )
     *
     * @IsGranted(
     *     "USER",
     *     subject="userdata"
     * )
     */
    public function edit(Request $request, UserData $userdata, int $id): Response
    {
//        $userdata = $userDataRepository->find($id);
        $form = $this->createForm(UserDataType::class, $userdata, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userDataService->save($userdata);
            $this->addFlash('success', 'message_updated_successfully');

            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('user_index');
            } else {
                return $this->redirectToRoute('recipe_index');
            }
        }

        return $this->render(
            'user/change_data.html.twig',
            [
                'form' => $form->createView(),
                'userdata' => $userdata,
            ]
        );
    }
}