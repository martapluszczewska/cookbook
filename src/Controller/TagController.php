<?php
/**
 * Tag controller.
 */

namespace App\Controller;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use App\Entity\Tag;
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
     * Show action.
     *
     * @param \App\Entity\Tag $tag Tag entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="tag_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Tag $tag): Response
    {
        return $this->render(
            'tag/show.html.twig',
            ['tag' => $tag]
        );
    }
}