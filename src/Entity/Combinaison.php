<?php

namespace App\Entity;

use App\Repository\CombinaisonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CombinaisonRepository::class)]
class Combinaison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'combinaisons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $question = null;

    #[ORM\ManyToOne(inversedBy: 'combinaisonsByChoice1')]
    private ?Choice $choice1 = null;

    #[ORM\ManyToOne(inversedBy: 'combinaisonsByChoice2')]
    private ?Choice $choice2 = null;

    #[ORM\ManyToOne(inversedBy: 'combinaisonsByChoice3')]
    private ?Choice $choice3 = null;

    #[ORM\ManyToOne(inversedBy: 'combinaisonsByChoice4')]
    private ?Choice $choice4 = null;

    #[ORM\ManyToMany(targetEntity: Association::class, inversedBy: 'combinaisons')]
    private Collection $associations;

    #[ORM\ManyToMany(targetEntity: Choice::class, inversedBy: 'previousChoices')]
    private Collection $nextChoices;

    #[ORM\OneToMany(mappedBy: 'combinaison', targetEntity: User::class)]
    private Collection $users;

    public function __construct()
    {
        $this->associations = new ArrayCollection();
        $this->nextChoices = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getChoice1(): ?Choice
    {
        return $this->choice1;
    }

    public function setChoice1(?Choice $choice1): static
    {
        $this->choice1 = $choice1;

        return $this;
    }

    public function getChoice2(): ?Choice
    {
        return $this->choice2;
    }

    public function setChoice2(?Choice $choice2): static
    {
        $this->choice2 = $choice2;

        return $this;
    }

    public function getChoice3(): ?Choice
    {
        return $this->choice3;
    }

    public function setChoice3(?Choice $choice3): static
    {
        $this->choice3 = $choice3;

        return $this;
    }

    public function getChoice4(): ?Choice
    {
        return $this->choice4;
    }

    public function setChoice4(?Choice $choice4): static
    {
        $this->choice4 = $choice4;

        return $this;
    }

    /**
     * @return Collection<int, Association>
     */
    public function getAssociations(): Collection
    {
        return $this->associations;
    }

    public function addAssociation(Association $association): static
    {
        if (!$this->associations->contains($association)) {
            $this->associations->add($association);
        }

        return $this;
    }

    public function removeAssociation(Association $association): static
    {
        $this->associations->removeElement($association);

        return $this;
    }

    /**
     * @return Collection<int, Choice>
     */
    public function getNextChoices(): Collection
    {
        return $this->nextChoices;
    }

    public function addNextChoice(Choice $nextChoice): static
    {
        if (!$this->nextChoices->contains($nextChoice)) {
            $this->nextChoices->add($nextChoice);
        }

        return $this;
    }

    public function removeNextChoice(Choice $nextChoice): static
    {
        $this->nextChoices->removeElement($nextChoice);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setCombinaison($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCombinaison() === $this) {
                $user->setCombinaison(null);
            }
        }

        return $this;
    }

    public function isOver(): bool
    {
        return $this->nextChoices->isEmpty() and !$this->associations->isEmpty();
    }
}
