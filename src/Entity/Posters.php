<?php

namespace App\Entity;

use App\Repository\PostersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostersRepository::class)
 */
class Posters
{
    public const view = 0;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title_post;

    /**
     * @ORM\Column(type="text")
     */
    private $text_post;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_post;

    /**
     * @ORM\Column(type="integer")
     */
    private $count_view;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Comments::class, mappedBy="poster", cascade={"all"}, orphanRemoval=true)
     */
    private $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitlePost(): ?string
    {
        return $this->title_post;
    }

    public function setTitlePost(string $title_post): self
    {
        $this->title_post = $title_post;

        return $this;
    }

    public function getTextPost(): ?string
    {
        return $this->text_post;
    }

    public function setTextPost(string $text_post): self
    {
        $this->text_post = $text_post;

        return $this;
    }

    public function getDatePost(): ?\DateTimeInterface
    {
        return $this->date_post;
    }

    #public function setDatePost(\DateTimeInterface $date_post): self
    public function setDatePost(): self
    {
        $this->date_post = new \DateTime();

        return $this;
    }

    public function getCountView(): ?int
    {
        return $this->count_view;
    }

    public function setCountView(): self
    {
        $this->count_view = self::view;

        return $this;
    }

    public function NumCountView(int $count): self
    {
        $this->count_view+=$count;

        return $this;
    }

    public function getuser(): ?User
    {
        return $this->user;
    }

    public function setuser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Comments[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setPoster($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getPoster() === $this) {
                $comment->setPoster(null);
            }
        }

        return $this;
    }
}
