<?php
/**
 * UserData repository.
 */

namespace App\Repository;

use App\Entity\UserData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class UserDataRepository.
 *
 * @method UserData|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserData|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserData[]    findAll()
 * @method UserData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserDataRepository extends ServiceEntityRepository
{
    /**
     * UserDataRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserData::class);
    }

    /**
     * Save record.
     *
     * @param \App\Entity\UserData $userdata UserData entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(UserData $userdata): void
    {
        $this->_em->persist($userdata);
        $this->_em->flush($userdata);
    }
}
