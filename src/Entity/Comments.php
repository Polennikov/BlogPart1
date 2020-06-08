<?php

namespace App\Entity;

use App\Repository\CommentsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentsRepository::class)
 */
class Comments
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $text_comment;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_comment;

    /**
     * @ORM\ManyToOne(targetEntity=Posters::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $poster;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_comments;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTextComment(): ?string
    {
        return $this->text_comment;
    }

    public function setTextComment(string $text_comment): self
    {
        $this->text_comment = $text_comment;

        return $this;
    }

    public function getDateComment(): ?\DateTimeInterface
    {
        return $this->date_comment;
    }

    public function setDateComment(): self
    {
        $this->date_comment =  new \DateTime();

        return $this;
    }

    public function getPoster(): ?Posters
    {
        return $this->poster;
    }

    public function setPoster(?Posters $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getUserComments(): ?User
    {
        return $this->user_comments;
    }

    public function setUserComments(?User $user_comments): self
    {
        $this->user_comments = $user_comments;

        return $this;
    }
}
