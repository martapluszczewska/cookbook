<?php
/**
 * Tag controller.
 */

namespace App\Controller;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use App\Repository\TagRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TagController.
 *
 * @Route("/tag")
 */
class TagController extends AbstractController
{
    /**
     * Articles view action.
     *
     * @param Request $request
     * @param RecipeRepository $repository
     * @param PaginatorInterface $paginator
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(
     *     "/{title}/{id}",
     *     name="tag_recipes",
     * )
     */
    public function articlesView(Request $request, TagRepository $tagRepository, RecipeRepository $recipeRepository, PaginatorInterface $paginator, int $id): Response
    {
        $tag = $tagRepository->find($id);

        $pagination = $paginator->paginate(
            $recipeRepository->findbyTag($tag),
            $request->query->getInt('page', 1),
            Recipe::NUMBER_OF_ITEMS
        );

        return $this->render(
            'tag/view.html.twig',
            [
                'pagination' => $pagination,
                'tagName' => $tag->getName()
            ]
        );
    }
}