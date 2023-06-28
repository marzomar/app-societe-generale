<?php

namespace App\Entity;

use App\Repository\ChoiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChoiceRepository::class)]
class Choice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\Column(nullable: true)]
    private ?int $goBack = null;

    #[ORM\OneToMany(mappedBy: 'choice1', targetEntity: Combinaison::class)]
    private Collection $combinaisonsByChoice1;

    #[ORM\OneToMany(mappedBy: 'choice2', targetEntity: Combinaison::class)]
    private Collection $combinaisonsByChoice2;

    #[ORM\OneToMany(mappedBy: 'choice3', targetEntity: Combinaison::class)]
    private Collection $combinaisonsByChoice3;

    #[ORM\OneToMany(mappedBy: 'choice4', targetEntity: Combinaison::class)]
    private Collection $combinaisonsByChoice4;

    #[ORM\ManyToMany(targetEntity: Combinaison::class, mappedBy: 'nextChoices')]
    private Collection $previousChoices;

    public function __construct()
    {
        $this->combinaisonsByChoice1 = new ArrayCollection();
        $this->combinaisonsByChoice2 = new ArrayCollection();
        $this->combinaisonsByChoice3 = new ArrayCollection();
        $this->combinaisonsByChoice4 = new ArrayCollection();
        $this->previousChoices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
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

    public function getGoBack(): ?int
    {
        return $this->goBack;
    }

    public function setGoBack(?int $goBack): static
    {
        $this->goBack = $goBack;

        return $this;
    }

    /**
     * @return Collection<int, Combinaison>
     */
    public function getCombinaisonsByChoice1(): Collection
    {
        return $this->combinaisonsByChoice1;
    }

    public function addCombinaisonsByChoice1(Combinaison $combinaisonsByChoice1): static
    {
        if (!$this->combinaisonsByChoice1->contains($combinaisonsByChoice1)) {
            $this->combinaisonsByChoice1->add($combinaisonsByChoice1);
            $combinaisonsByChoice1->setChoice1($this);
        }

        return $this;
    }

    public function removeCombinaisonsByChoice1(Combinaison $combinaisonsByChoice1): static
    {
        if ($this->combinaisonsByChoice1->removeElement($combinaisonsByChoice1)) {
            // set the owning side to null (unless already changed)
            if ($combinaisonsByChoice1->getChoice1() === $this) {
                $combinaisonsByChoice1->setChoice1(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Combinaison>
     */
    public function getCombinaisonsByChoice2(): Collection
    {
        return $this->combinaisonsByChoice2;
    }

    public function addCombinaisonsByChoice2(Combinaison $combinaisonsByChoice2): static
    {
        if (!$this->combinaisonsByChoice2->contains($combinaisonsByChoice2)) {
            $this->combinaisonsByChoice2->add($combinaisonsByChoice2);
            $combinaisonsByChoice2->setChoice2($this);
        }

        return $this;
    }

    public function removeCombinaisonsByChoice2(Combinaison $combinaisonsByChoice2): static
    {
        if ($this->combinaisonsByChoice2->removeElement($combinaisonsByChoice2)) {
            // set the owning side to null (unless already changed)
            if ($combinaisonsByChoice2->getChoice2() === $this) {
                $combinaisonsByChoice2->setChoice2(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Combinaison>
     */
    public function getCombinaisonsByChoice3(): Collection
    {
        return $this->combinaisonsByChoice3;
    }

    public function addCombinaisonsByChoice3(Combinaison $combinaisonsByChoice3): static
    {
        if (!$this->combinaisonsByChoice3->contains($combinaisonsByChoice3)) {
            $this->combinaisonsByChoice3->add($combinaisonsByChoice3);
            $combinaisonsByChoice3->setChoice3($this);
        }

        return $this;
    }

    public function removeCombinaisonsByChoice3(Combinaison $combinaisonsByChoice3): static
    {
        if ($this->combinaisonsByChoice3->removeElement($combinaisonsByChoice3)) {
            // set the owning side to null (unless already changed)
            if ($combinaisonsByChoice3->getChoice3() === $this) {
                $combinaisonsByChoice3->setChoice3(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Combinaison>
     */
    public function getCombinaisonsByChoice4(): Collection
    {
        return $this->combinaisonsByChoice4;
    }

    public function addCombinaisonsByChoice4(Combinaison $combinaisonsByChoice4): static
    {
        if (!$this->combinaisonsByChoice4->contains($combinaisonsByChoice4)) {
            $this->combinaisonsByChoice4->add($combinaisonsByChoice4);
            $combinaisonsByChoice4->setChoice4($this);
        }

        return $this;
    }

    public function removeCombinaisonsByChoice4(Combinaison $combinaisonsByChoice4): static
    {
        if ($this->combinaisonsByChoice4->removeElement($combinaisonsByChoice4)) {
            // set the owning side to null (unless already changed)
            if ($combinaisonsByChoice4->getChoice4() === $this) {
                $combinaisonsByChoice4->setChoice4(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Combinaison>
     */
    public function getPreviousChoices(): Collection
    {
        return $this->previousChoices;
    }

    public function addPreviousChoice(Combinaison $previousChoice): static
    {
        if (!$this->previousChoices->contains($previousChoice)) {
            $this->previousChoices->add($previousChoice);
            $previousChoice->addNextChoice($this);
        }

        return $this;
    }

    public function removePreviousChoice(Combinaison $previousChoice): static
    {
        if ($this->previousChoices->removeElement($previousChoice)) {
            $previousChoice->removeNextChoice($this);
        }

        return $this;
    }
}
