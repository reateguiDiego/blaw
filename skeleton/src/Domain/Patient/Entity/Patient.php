<?php

namespace App\Domain\Patient\Entity;

use App\Domain\User\Entity\User;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 100)]
    private string $fullName;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $notes = null;

    #[ORM\OneToOne(inversedBy: 'patient')]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    public function getId(): int { return $this->id; }

    public function getFullName(): string { return $this->fullName; }
    public function setFullName(string $name): self { $this->fullName = $name; return $this; }

    public function getNotes(): ?string { return $this->notes; }
    public function setNotes(?string $notes): self { $this->notes = $notes; return $this; }

    public function getUser(): User { return $this->user; }
    public function setUser(User $user): self { $this->user = $user; return $this; }
}
