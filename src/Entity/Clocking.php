<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Repository\ClockingRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ClockingRepository::class)]
class Clocking
{
    #[ORM\ManyToOne(inversedBy: 'clockings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User              $clockingUser    = null;
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?DateTimeInterface $date            = null;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int               $id              = null;

    #[ORM\OneToMany(mappedBy: 'clocking', targetEntity: ClockingItem::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $clockingItems;

    public function __construct()
    {
        $this->clockingItems = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getClockingUser() : ?User
    {
        return $this->clockingUser;
    }

    public function setClockingUser(?User $clockingUser) : static
    {
        $this->clockingUser = $clockingUser;

        return $this;
    }

    public function getDate() : ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?DateTimeInterface $date) : void
    {
        $this->date = $date;
    }

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getClockingItems(): Collection
    {
        return $this->clockingItems;
    }

    public function addClockingItem(ClockingItem $clockingItem): static
    {
        if (!$this->clockingItems->contains($clockingItem)) {
            $this->clockingItems->add($clockingItem);
            $clockingItem->setClocking($this);
        }

        return $this;
    }
    
    public function removeClockingItem(ClockingItem $clockingItem): static
    {
        if ($this->clockingItems->removeElement($clockingItem)) {
            if ($clockingItem->getClocking() === $this) {
                $clockingItem->setClocking(null);
            }
        }

        return $this;
    }
}
