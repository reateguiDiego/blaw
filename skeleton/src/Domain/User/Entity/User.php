<?php

namespace App\Domain\User\Entity;

use App\Domain\Therapist\Entity\Therapist;
use App\Domain\Patient\Entity\Patient;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(unique: true)]
    private string $email;

    #[ORM\Column]
    private string $password;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Therapist $therapist = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Patient $patient = null;

    public function getId(): int { return $this->id; }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }

    public function getPassword(): string { return $this->password; }
    public function setPassword(string $password): self { $this->password = $password; return $this; }

    public function getRoles(): array { return array_unique(array_merge($this->roles, ['ROLE_USER'])); }
    public function setRoles(array $roles): self { $this->roles = $roles; return $this; }

    public function getTherapist(): ?Therapist { return $this->therapist; }
    public function setTherapist(?Therapist $therapist): self { $this->therapist = $therapist; return $this; }

    public function getPatient(): ?Patient { return $this->patient; }
    public function setPatient(?Patient $patient): self { $this->patient = $patient; return $this; }

    // UserInterface
    public function getUserIdentifier(): string { return $this->email; }
    public function eraseCredentials():void
    {

    }
}
