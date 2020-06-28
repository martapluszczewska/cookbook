<?php
/**
 * Ingredient repository.
 */

namespace App\Repository;

use App\Entity\Ingredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class IngredientRepository.
 *
 * @method Ingredient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ingredient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ingredient[]    findAll()
 * @method Ingredient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredientRepository extends ServiceEntityRepository
{
    /**
     * IngredientRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ingredient::class);
    }

    /**
     * Save record.
     *
     * @param \App\Entity\Ingredient $ingredient Ingredient entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Ingredient $ingredient): void
    {
        $this->_em->persist($ingredient);
        $this->_em->flush($ingredient);
    }

    /**
     * Delete record.
     *
     * @param \App\Entity\Ingredient $ingredient Ingredient entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Ingredient $ingredient): void
    {
        $this->_em->remove($ingredient);
        $this->_em->flush($ingredient);
    }
}
