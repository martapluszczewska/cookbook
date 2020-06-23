<?php
/**
 * Recipe controller.
 */

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\Comment;
use App\Form\RecipeType;
use App\Form\CommentType;
use App\Repository\RecipeRepository;
use App\Repository\CommentRepository;
use App\Repository\RatingRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class RecipeController.
 *
 * @Route("/recipe")
 */
class RecipeController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Repository\RecipeRepository $recipeRepository Recipe repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator Paginator
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="recipe_index",
     * )
     */
    public function index(Request $request, RecipeRepository $recipeRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $recipeRepository->queryAll(),
            $request->query->getInt('page', 1),
            RecipeRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'recipe/index.html.twig',
            ['pagination' => $pagination]
        );
    }

//    /**
//     * Show action.
//     *
//     * @param \App\Entity\Recipe $recipe Recipe entity
//     *
//     * @return \Symfony\Component\HttpFoundation\Response HTTP response
//     *
//     * @Route(
//     *     "/{id}",
//     *     methods={"GET"},
//     *     name="recipe_show",
//     *     requirements={"id": "[1-9]\d*"},
//     * )
//     */
//    public function show(Recipe $recipe): Response
//    {
//        return $this->render(
//            'recipe/show.html.twig',
//            ['recipe' => $recipe]
//        );
//    }

    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Repository\RecipeRepository $recipeRepository Recipe repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="recipe_create",
     * )
     */
    public function create(Request $request, RecipeRepository $recipeRepository): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('recipe_index');
        }

        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipeRepository->save($recipe);
            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('recipe_index');
        }

        return $this->render(
            'recipe/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Recipe $recipe Recipe entity
     * @param \App\Repository\RecipeRepository $recipeRepository Recipe repository
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
     *     name="recipe_edit",
     * )
     */
    public function edit(Request $request, Recipe $recipe, RecipeRepository $recipeRepository): Response
    {
        $form = $this->createForm(RecipeType::class, $recipe, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipeRepository->save($recipe);
            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('recipe_index');
        }

        return $this->render(
            'recipe/edit.html.twig',
            [
                'form' => $form->createView(),
                'recipe' => $recipe,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Recipe $recipe Recipe entity
     * @param \App\Repository\RecipeRepository $recipeRepository Recipe repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="recipe_delete",
     * )
     */
    public function delete(Request $request, Recipe $recipe, RecipeRepository $recipeRepository): Response
    {
        $form = $this->createForm(FormType::class, $recipe, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $recipeRepository->delete($recipe);
            $this->addFlash('success', 'message_deleted_successfully');

            return $this->redirectToRoute('recipe_index');
        }

        return $this->render(
            'recipe/delete.html.twig',
            [
                'form' => $form->createView(),
                'recipe' => $recipe,
            ]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Entity\Recipe $recipe Recipe entity
     * @param int $id Element Id
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET", "POST"},
     *     name="recipe_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Request $request, RecipeRepository $recipeRepository, CommentRepository $commentRepository, RatingRepository $ratingRepository, int $id): Response
    {
        $recipe = $recipeRepository->find($id);
        $form = null;
        $rating = $ratingRepository->calculateAvg($recipe);

        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $comment = new Comment();

            $form = $this->createForm(CommentType::class, $comment);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $comment->setRecipe($recipe);
                $comment->setAuthor($this->getUser());
                $commentRepository->save($comment);

                $this->addFlash('success', 'message.comment_created_successfully');

                return $this->redirectToRoute('recipe_show', ['id' => $id]);
            }
        }

        return $this->render(
            'recipe/show.html.twig',
            [
                'recipe' => $recipe,
                'rating' => $rating,
                'comments' => $commentRepository->findForRecipe($id),
                'comment_form' => is_null($form) ? null : $form->createView(),
            ]
        );
    }
}