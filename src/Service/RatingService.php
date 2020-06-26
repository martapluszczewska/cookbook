<?php
/**
 * Rating service.
 */

namespace App\Service;

use App\Entity\Rating;
use App\Entity\Recipe;
use App\Repository\RatingRepository;
use Doctrine\ORM\NonUniqueResultException;

/**
 * Class RatingService.
 */
class RatingService
{
    /**
     * Rating repository.
     *
     * @var \App\Repository\RatingRepository
     */
    private $ratingRepository;

    /**
     * RatingService constructor.
     *
     * @param \App\Repository\RatingRepository $ratingRepository Rating repository
     */
    public function __construct(RatingRepository $ratingRepository)
    {
        $this->ratingRepository = $ratingRepository;
    }

    /**
     * Save rating.
     *
     * @param \App\Entity\Rating $rating Rating entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Rating $rating): void
    {
        $this->ratingRepository->save($rating);
    }

    /**
     * Calculate average.
     *
     * @param Recipe $recipe
     *
     * @return float
     *
     * @throws NonUniqueResultException
     */
    public function calculateAvg(Recipe $recipe): float
    {
        return $this->ratingRepository->calculateAvg($recipe);
    }
}
