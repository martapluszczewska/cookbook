<?php
/**
 * User data fixtures.
 */

namespace App\DataFixtures;

use App\Entity\UserData;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class UserDataFixtures.
 */
class UserDataFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'user_data', function ($i) {
            $userData = new UserData();
            $userData->setFirstName($this->faker->firstName);
            $userData->setLastName($this->faker->lastName);
            $userData->setNick($this->faker->userName);
            $userData->setUser($this->getReference('users_'.$i));

            return $userData;
        });

        $this->createMany(3, 'user_data_admin', function ($i) {
            $userData = new UserData();
            $userData->setFirstName($this->faker->firstName);
            $userData->setLastName($this->faker->lastName);
            $userData->setNick($this->faker->userName);
            $userData->setUser($this->getReference('admins_'.$i));

            return $userData;
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
        return [UserFixtures::class];
    }
}
