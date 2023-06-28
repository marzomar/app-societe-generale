<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: Combinaison::class)]
    private Collection $combinaisons;

    public function __construct()
    {
        $this->combinaisons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Collection<int, Combinaison>
     */
    public function getCombinaisons(): Collection
    {
        return $this->combinaisons;
    }

    public function addCombinaison(Combinaison $combinaison): static
    {
        if (!$this->combinaisons->contains($combinaison)) {
            $this->combinaisons->add($combinaison);
            $combinaison->setQuestion($this);
        }

        return $this;
    }

    public function removeCombinaison(Combinaison $combinaison): static
    {
        if ($this->combinaisons->removeElement($combinaison)) {
            // set the owning side to null (unless already changed)
            if ($combinaison->getQuestion() === $this) {
                $combinaison->setQuestion(null);
            }
        }

        return $this;
    }
}
