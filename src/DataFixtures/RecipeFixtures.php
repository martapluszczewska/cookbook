<?php
/**
 * Recipe fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Recipe;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class RecipeFixtures.
 */
class RecipeFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(50, 'recipes', function ($i) {
            $recipe = new Recipe();
            $recipe->setTitle($this->faker->sentence);
            $recipe->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $recipe->setUpdatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $recipe->setCategory($this->getRandomReference('categories'));

            $tags = $this->getRandomReferences(
                'tags',
                $this->faker->numberBetween(0, 5)
            );

            foreach ($tags as $tag) {
                $recipe->addTag($tag);
            }

            $ingredients = $this->getRandomReferences(
                'ingredients',
                $this->faker->numberBetween(0, 10)
            );

            foreach ($ingredients as $ingredient) {
                $recipe->addIngredient($ingredient);
            }

            return $recipe;
        });

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array Array of dependencies
     */
    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }
}