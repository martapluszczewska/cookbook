<?php
/**
 * Rating controller.
 */
namespace App\Controller;
use App\Entity\Rating;
use App\Form\RatingType;
use App\Repository\RatingRepository;
use App\Repository\RecipeRepository;
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
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Repository\RecipeRepository $recipeRepository Recipe repository
     * @param \App\Repository\RatingRepository $ratingRepository Rating repository
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
    public function create(Request $request, $id, RecipeRepository $recipeRepository, RatingRepository $ratingRepository): Response
    {
        $rating = new Rating();
        $rating->setVoter($this->getUser());
        $RecipeById = $recipeRepository->findOneById($id);
        $rating->setRecipe($RecipeById);

        $form = $this->createForm(RatingType::class, $rating);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $ratingRepository->save($rating);
            $this->addFlash('success', 'message.rating_created_successfully');
            return $this->redirectToRoute('recipe_index');
        }
        return $this->render(
            'rating/create.html.twig',
            ['form' => $form->createView(), 'recipe' => $id]
        );
    }
}