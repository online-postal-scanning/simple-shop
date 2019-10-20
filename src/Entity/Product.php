<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Entity;

use Money\Money;

final class Product
{
    /** @var bool */
    private $active;
    /** @var \IamPersistent\SimpleShop\Entity\Category[] */
    private $categories = [];
    /** @var string|null */
    private $description;
    /** @var mixed */
    private $id;
    /** @var string */
    private $name;
    /** @var \Money\Money */
    private $price;
    /** @var bool */
    private $taxable;

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): Product
    {
        $this->active = $active;

        return $this;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(array $categories): Product
    {
        $this->categories = $categories;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Product
    {
        $this->description = $description;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Product
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): Money
    {
        return $this->price;
    }

    public function setPrice(Money $price): Product
    {
        $this->price = $price;

        return $this;
    }

    public function isTaxable(): bool
    {
        return $this->taxable;
    }

    public function setTaxable(bool $taxable): Product
    {
        $this->taxable = $taxable;

        return $this;
    }
}
