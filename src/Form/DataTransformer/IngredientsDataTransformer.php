<?php
/**
 * Ingredients data transformer.
 */

namespace App\Form\DataTransformer;

use App\Entity\Ingredient;
use App\Repository\IngredientRepository;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class IngredientsDataTransformer.
 */
class IngredientsDataTransformer implements DataTransformerInterface
{
    /**
     * Ingredient repository.
     *
     * @var \App\Repository\IngredientRepository
     */
    private $repository;

    /**
     * IngredientsDataTransformer constructor.
     *
     * @param \App\Repository\IngredientRepository $repository Ingredient repository
     */
    public function __construct(IngredientRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Transform array of ingredients to string of names.
     *
     * @param \Doctrine\Common\Collections\Collection $ingredients Ingredients entity collection
     *
     * @return string Result
     */
    public function transform($ingredients): string
    {
        if (null == $ingredients) {
            return '';
        }

        $ingredientNames = [];

        foreach ($ingredients as $ingredient) {
            $ingredientNames[] = $ingredient->getTitle();
        }

        return implode(',', $ingredientNames);
    }

    /**
     * Transform string of ingredient names into array of Ingredient entities.
     *
     * @param string $value String of ingredient names
     *
     * @return array Result
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function reverseTransform($value): array
    {
        $ingredientTitles = explode(',', $value);

        $ingredients = [];

        foreach ($ingredientTitles as $ingredientTitle) {
            if ('' !== trim($ingredientTitle)) {
                $ingredient = $this->repository->findOneByTitle(strtolower($ingredientTitle));
                if (null == $ingredient) {
                    $ingredient = new Ingredient();
                    $ingredient->setTitle($ingredientTitle);
                    $this->repository->save($ingredient);
                }
                $ingredients[] = $ingredient;
            }
        }

        return $ingredients;
    }
}