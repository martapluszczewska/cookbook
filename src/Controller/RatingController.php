<?php
/**
 * Rating controller.
 */
namespace App\Controller;

use App\Entity\Rating;
use App\Entity\Recipe;
use App\Form\RatingType;
use App\Service\RatingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RatingController.
 *
 * @Route("/rating")
 */
class RatingController extends AbstractController
{
    /**
     * Rating service.
     *
     * @var \App\Service\RatingService
     */
    private $ratingService;

    /**
     * Recipe service.
     *
     * @var \App\Service\RecipeService
     */
    private $recipeService;

    /**
     * RatingController constructor.
     *
     * @param \App\Service\RatingService $ratingService Rating service
     */
    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    /**
     * Create action.
     *
     * @param \App\Entity\Recipe                        $recipe  Recipe entity
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/new",
     *     methods={"GET", "POST"},
     *     name="rating_new",
     * )
     */
    public function create(Recipe $recipe, Request $request, int $id): Response
    {
        $rating = new Rating();
        $rating->setVoter($this->getUser());
//        $RecipeById = $this->recipeService->findOneById($id);
//        $rating->setRecipe($RecipeById);
        $rating->setRecipe($recipe);

        $form = $this->createForm(RatingType::class, $rating);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->ratingService->save($rating);
//            $ratingRepository->save($rating);
            $this->addFlash('success', 'message.rating_created_successfully');
            return $this->redirectToRoute('recipe_show', ['id' => $id]);
        }
        return $this->render(
            'rating/create.html.twig',
            [
                'form' => $form->createView(),
                'recipe' => $id,
            ]
        );
    }
}