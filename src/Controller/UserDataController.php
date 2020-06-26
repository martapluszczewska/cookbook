<?php
/**
 * UserData controller.
 */

namespace App\Controller;

use App\Entity\UserData;
use App\Repository\UserDataRepository;
use App\Form\UserDataType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
     * Change data action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\UserData $userdata UserData entity
     * @param \App\Repository\UserDataRepository $userDataRepository UserData repository
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
    public function edit(Request $request, UserData $userdata, UserDataRepository $userDataRepository, int $id): Response
    {
        $userdata = $userDataRepository->find($id);
        $form = $this->createForm(UserDataType::class, $userdata, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userDataRepository->save($userdata);
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