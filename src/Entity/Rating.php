<?php
/**
 * Rating entity.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Rating.
 *
 * @ORM\Entity(repositoryClass="App\Repository\RatingRepository")
 * @ORM\Table(name="ratings")
 */
class Rating
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
     * Value.
     *
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Assert\Type(type="int")
     * @Assert\Range(
     *      min = 0,
     *      max = 5
     * )
     */
    private $value;

    /**
     * Recipe.
     *
     * @var \App\Entity\Recipe Recipe
     *
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\Recipe",
     *     inversedBy="ratings"
     * )
     * @ORM\JoinColumn(nullable=false)
     */
    private $recipe;

    /**
     * Voter.
     *
     * @var \App\Entity\User User
     *
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\User",
     *     inversedBy="ratings"
     * )
     * @ORM\JoinColumn(nullable=false)
     */
    private $voter;

    /**
     * Getter for Id.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Value.
     *
     * @return int|null
     */
    public function getValue(): ?int
    {
        return $this->value;
    }

    /**
     * Setter for Value.
     *
     * @param int $value
     */
    public function setValue(int $value): void
    {
        $this->value = $value;
    }

    /**
     * Getter for Recipe.
     *
     * @return Recipe|null
     */
    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    /**
     * Setter for Recipe.
     *
     * @param Recipe|null $recipe
     */
    public function setRecipe(?Recipe $recipe): void
    {
        $this->recipe = $recipe;
    }

    /**
     * Getter for User.
     *
     * @return User|null
     */
    public function getVoter(): ?User
    {
        return $this->voter;
    }

    /**
     * Setter for User.
     *
     * @param User|null $voter
     */
    public function setVoter(?User $voter): void
    {
        $this->voter = $voter;
    }
}
