<?php
/**
 * Ingredient entity.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Ingredient.
 *
 * @ORM\Entity(repositoryClass="App\Repository\IngredientRepository")
 * @ORM\Table(name="ingredients")
 *
 * @UniqueEntity(fields={"title"})
 */
class Ingredient
{
    /**
     * Primary key.
     *
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Title.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=64,
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="64",
     * )
     */
    private $title;

    /**
     * Recipes.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection|\App\Entity\Recipe[] Recipes
     *
     * @ORM\ManyToMany(
     *     targetEntity="App\Entity\Recipe",
     *     mappedBy="ingredients"
     * )
     *
     * @Assert\Type(type="Doctrine\Common\Collections\ArrayCollection")
     */
    private $recipes;

    /**
     * Ingredient constructor.
     */
    public function __construct()
    {
        $this->recipes = new ArrayCollection();
    }

    /**
     * Getter for Id.
     *
     * @return int|null Result
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Title.
     *
     * @return string|null Title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Setter for Title.
     *
     * @param string $title Title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Getter for recipes.
     *
     * @return \Doctrine\Common\Collections\Collection|\App\Entity\Recipe[] Recipes collection
     */
    public function getRecipes(): Collection
    {
        return $this->recipes;
    }

    /**
     * Add recipe to collection.
     *
     * @param \App\Entity\Recipe $recipe Recipe entity
     */
    public function addRecipe(Recipe $recipe): void
    {
        if (!$this->recipes->contains($recipe)) {
            $this->recipes[] = $recipe;
            $recipe->addIngredient($this);
        }
    }

    /**
     * Remove recipe from collection.
     *
     * @param \App\Entity\Recipe $recipe Recipe entity
     */
    public function removeRecipe(Recipe $recipe): void
    {
        if ($this->recipes->contains($recipe)) {
            $this->recipes->removeElement($recipe);
            $recipe->removeIngredient($this);
        }
    }
}
