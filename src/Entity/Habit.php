<?php

namespace App\Entity;

use App\Repository\HabitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HabitRepository::class)]
class Habit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $Frequence = null;

    #[ORM\Column]
    private array $Date = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getFrequence(): ?string
    {
        return $this->Frequence;
    }

    public function setFrequence(string $Frequence): static
    {
        $this->Frequence = $Frequence;

        return $this;
    }

    public function getDate(): array
    {
        return $this->Date;
    }

    public function setDate(array $Date): static
    {
        $this->Date = $Date;

        return $this;
    }
}
