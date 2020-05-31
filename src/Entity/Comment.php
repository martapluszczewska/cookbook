<?php
/**
 * Comment entity.
 */

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Comment.
 *
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 * @ORM\Table(name="comments")
 */
class Comment
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
     * Created at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\DateTime
     *
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * Text.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=255
     * )
     */
    private $text;

    /**
     * Recipe.
     *
     * @var \App\Entity\Recipe Recipe
     *
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\Recipe",
     *     inversedBy="comments"
     * )
     * @ORM\JoinColumn(nullable=false)
     */
    private $recipe;

    /**
     * User.
     *
     * @var \App\Entity\User User
     *
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\User",
     *     inversedBy="comments"
     * )
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

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
     * Getter for Text.
     *
     * @return string|null Text
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * Setter for Text.
     *
     * @param string $text Text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * Getter for recipe.
     *
     * @return \App\Entity\Recipe|null Recipe
     */
    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    /**
     * Setter for recipe.
     *
     * @param \App\Entity\Recipe|null $recipe Recipe
     */
    public function setRecipe(?Recipe $recipe): void
    {
        $this->recipe = $recipe;
    }

    /**
     * Getter for user.
     *
     * @return \App\Entity\User|null User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Setter for user.
     *
     * @param \App\Entity\User|null $user User
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
    }
}
