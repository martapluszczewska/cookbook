<?php
/**
 * Comment fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Persistence\ObjectManager;

/**
 * Class CommentFixtures.
 */
class CommentFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(50, 'comments', function ($i) {
            $comment = new Comment();
            $comment->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $comment->setText($this->faker->sentence);
            $comment->setRecipe($this->getRandomReference('recipes'));
            $comment->setUser($this->getRandomReference('users'));

            return $comment;
        });

            $manager->flush();
    }
}
