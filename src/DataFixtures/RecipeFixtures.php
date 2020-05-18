<?php
/**
 * Recipe fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Recipe;
use Doctrine\Persistence\ObjectManager;

/**
 * Class RecipeFixtures.
 */
class RecipeFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; ++$i) {
            $recipe = new Recipe();
            $recipe->setTitle($this->faker->sentence);
            $recipe->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $recipe->setUpdatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $this->manager->persist($recipe);
        }

        $manager->flush();
    }
}