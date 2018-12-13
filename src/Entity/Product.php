<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $productImage;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Box", mappedBy="products")
     */
    private $relationBoxes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Box", mappedBy="Products")
     */
    private $relatedBoxes;

    public function __construct()
    {
        $this->relationBoxes = new ArrayCollection();

        $this->relatedBoxes = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getProductImage(): ?string
    {
        return $this->productImage;
    }

    public function setProductImage(string $productImage): self
    {
        $this->productImage = $productImage;

        return $this;
    }

    /**
     * @return Collection|Box[]
     */
    public function getRelationBoxes(): Collection
    {
        return $this->relationBoxes;
    }

    public function addRelationBox(Box $relationBox): self
    {
        if (!$this->relationBoxes->contains($relationBox)) {
            $this->relationBoxes[] = $relationBox;
            $relationBox->addProduct($this);
        }

        return $this;
    }

    public function removeRelationBox(Box $relationBox): self
    {
        if ($this->relationBoxes->contains($relationBox)) {
            $this->relationBoxes->removeElement($relationBox);
            $relationBox->removeProduct($this);
        }

        return $this;
    }

    /**
     * @return Collection|Box[]
     */
    public function getRelatedBoxes(): Collection
    {
        return $this->relatedBoxes;
    }

    public function addRelatedBox(Box $relatedBox): self
    {
        if (!$this->relatedBoxes->contains($relatedBox)) {
            $this->relatedBoxes[] = $relatedBox;
            $relatedBox->addProduct($this);
        }

        return $this;
    }

    public function removeRelatedBox(Box $relatedBox): self
    {
        if ($this->relatedBoxes->contains($relatedBox)) {
            $this->relatedBoxes->removeElement($relatedBox);
            $relatedBox->removeProduct($this);
        }

        return $this;
    }
}
