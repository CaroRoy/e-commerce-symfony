<?php

namespace App\Entity;

use App\Repository\PurchaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PurchaseRepository::class)
 */
class Purchase
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="purchases")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @ORM\Column(type="integer")
     */
    private $total;

    /**
     * @ORM\OneToMany(targetEntity=LinePurchase::class, mappedBy="purchase", orphanRemoval=true)
     */
    private $linePurchases;

    public function __construct()
    {
        $this->linePurchases = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCustomer(): ?User
    {
        return $this->customer;
    }

    public function setCustomer(?User $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return Collection|LinePurchase[]
     */
    public function getLinePurchases(): Collection
    {
        return $this->linePurchases;
    }

    public function addLinePurchase(LinePurchase $linePurchase): self
    {
        if (!$this->linePurchases->contains($linePurchase)) {
            $this->linePurchases[] = $linePurchase;
            $linePurchase->setPurchase($this);
        }

        return $this;
    }

    public function removeLinePurchase(LinePurchase $linePurchase): self
    {
        if ($this->linePurchases->removeElement($linePurchase)) {
            // set the owning side to null (unless already changed)
            if ($linePurchase->getPurchase() === $this) {
                $linePurchase->setPurchase(null);
            }
        }

        return $this;
    }
}
