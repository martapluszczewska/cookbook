<?php
/**
 * Recipe controller.
 */

namespace App\Controller;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @param \App\Repository\RecipeRepository $recipeRepository Recipe repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="recipe_index",
     * )
     */
    public function index(RecipeRepository $recipeRepository): Response
    {
        return $this->render(
            'recipe/index.html.twig',
            ['recipes' => $recipeRepository->findAll()]
        );
    }
    /**
     * Show action.
     *
     * @param \App\Entity\Recipe $recipe Recipe entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="recipe_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Recipe $recipe): Response
    {
        return $this->render(
            'recipe/show.html.twig',
            ['recipe' => $recipe]
        );
    }
}