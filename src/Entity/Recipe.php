<?php
/**
 * Recipe entity.
 */

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Recipe.
 *
 * @ORM\Entity(repositoryClass="App\Repository\RecipeRepository")
 * @ORM\Table(name="recipes")
 */
class Recipe
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
     *     length=255
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="255",
     * )
     */
    private $title;

    /**
     * Created at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\Type(type="\DateTimeInterface")
     *
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * Updated at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\Type(type="\DateTimeInterface")
     *
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * Category.
     *
     * @var \App\Entity\Category Category
     *
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\Category",
     *     inversedBy="recipes"
     * )
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * Tags.
     *
     * @var array
     *
     * @ORM\ManyToMany(
     *     targetEntity="App\Entity\Tag",
     *     inversedBy="recipes",
     *     orphanRemoval=true
     * )
     * @ORM\JoinTable(name="recipes_tags")
     */
    private $tags;

    /**
     * Comment.
     *
     * @var \App\Entity\Comment Comment
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Comment",
     *     mappedBy="recipe",
     *     orphanRemoval=true
     * )
     */
    private $comments;

    /**
     * Ingredients.
     *
     * @var array
     *
     * @ORM\ManyToMany(
     *     targetEntity="App\Entity\Ingredient",
     *     inversedBy="recipes",
     *     orphanRemoval=true
     * )
     * @ORM\JoinTable(name="recipes_ingredients")
     */
    private $ingredients;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Rating",
     *     mappedBy="recipe",
     *     orphanRemoval=true
     * )
     */
    private $ratings;

    /**
     * Description.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=512
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="64",
     *     max="512",
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $rating;

    /**
     * @ORM\Column(type="string", length=512, nullable=true)
     */
    private $image;

    /**
     * Recipe constructor.
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
        $this->ratings = new ArrayCollection();
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
     * Getter for Created At.
     *
     * @return \DateTimeInterface|null Created at
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Setter for Created at.
     *
     * @param \DateTimeInterface $createdAt Created at
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Getter for Updated at.
     *
     * @return \DateTimeInterface|null Updated at
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Setter for Updated at.
     *
     * @param \DateTimeInterface $updatedAt Updated at
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Getter for category.
     *
     * @return \App\Entity\Category|null Category
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * Setter for category.
     *
     * @param \App\Entity\Category|null $category Category
     */
    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }

    /**
     * Getter for tags.
     *
     * @return \Doctrine\Common\Collections\Collection|\App\Entity\Tag[] Tags collection
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * Add tag to collection.
     *
     * @param \App\Entity\Tag $tag Tag entity
     */
    public function addTag(Tag $tag): void
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }
    }

    /**
     * Remove tag from collection.
     *
     * @param \App\Entity\Tag $tag Tag entity
     */
    public function removeTag(Tag $tag): void
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }
    }

    /**
     * Getter for Comment.
     *
     * @return Collection|Comment[] Comment
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * @param Comment $comment
     *
     * @return $this
     */
    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setRecipe($this);
        }

        return $this;
    }

    /**
     * @param Comment $comment
     *
     * @return $this
     */
    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            if ($comment->getRecipe() === $this) {
                $comment->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * Getter for ingredients.
     *
     * @return \Doctrine\Common\Collections\Collection|\App\Entity\Ingredient[] Ingredients collection
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    /**
     * Add ingredient to collection.
     *
     * @param \App\Entity\Ingredient $ingredient Ingredient entity
     */
    public function addIngredient(Ingredient $ingredient): void
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients[] = $ingredient;
        }
    }

    /**
     * Remove ingredient from collection.
     *
     * @param \App\Entity\Ingredient $ingredient Ingredient entity
     */
    public function removeIngredient(Ingredient $ingredient): void
    {
        if ($this->ingredients->contains($ingredient)) {
            $this->ingredients->removeElement($ingredient);
        }
    }

    /**
     * Getter for ratings.
     *
     * @return Collection|Rating[]
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    /**
     * @param Rating $rating
     */
    public function addRating(Rating $rating): void
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setRecipe($this);
        }
    }

    /**
     * @param Rating $rating
     */
    public function removeRating(Rating $rating): void
    {
        if ($this->ratings->contains($rating)) {
            $this->ratings->removeElement($rating);
            // set the owning side to null (unless already changed)
            if ($rating->getRecipe() === $this) {
                $rating->setRecipe(null);
            }
        }
    }

    /**
     * Getter for description.
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Setter for description.
     *
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Getter for rating.
     *
     * @return float|null
     */
    public function getRating(): ?float
    {
        return $this->rating;
    }

    /**
     * Setter for rating.
     *
     * @param float|null $rating
     */
    public function setRating(?float $rating): void
    {
        $this->rating = $rating;
    }

    /**
     * Getter for image.
     *
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * Setter for image.
     *
     * @param string|null $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }
}
