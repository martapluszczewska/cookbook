<?php
/**
 * User controller.
 */

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\UserPassType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserController.
 *
 * @Route("/user")
 *
 * @IsGranted("ROLE_USER")
 */
class UserController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Repository\UserRepository        $userRepository User repository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator          Paginator
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="user_index",
     * )
     *
     * @IsGranted("ROLE_USER")
     */
    public function index(Request $request, UserRepository $userRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $userRepository->queryAll(),
            $request->query->getInt('page', 1),
            UserRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'user/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Entity\User $user User entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="user_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     *
     * @IsGranted("ROLE_USER")
     */
    public function show(User $user): Response
    {
        return $this->render(
            'user/show.html.twig',
            ['user' => $user]
        );
    }

    /**
     * Change password action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\User $user User entity
     * @param \App\Repository\UserRepository $userRepository User repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit_pass",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="user_edit_pass",
     * )
     *
     * @IsGranted(
     *     "USER",
     *     subject="user",
     * )
     * @IsGranted("ROLE_USER")
     */
    public function userEditPass(Request $request, User $user, UserRepository $userRepository, UserPasswordEncoderInterface $encoder, int $id): Response
    {
        $user = $userRepository->find($id);
        $form = $this->createForm(UserPassType::class, $user, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $encoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $userRepository->save($user);
            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('user_show', ['id' => $id]);
        }

        return $this->render(
            'user/change_pass.html.twig',
            [
                'form' => $form->createView(),
                'user' => $user,
            ]
        );
    }
}