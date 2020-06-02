<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use Doctrine\Persistence\ObjectManager;

/**
 * Class IngredientFixtures.
 */
class IngredientFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'ingredients', function ($i) {
            $ingredient = new Ingredient();
            $ingredient->setTitle($this->faker->word);

            return $ingredient;
        });

        $manager->flush();
    }
}
