<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Entity;

use Money\Money;

class InvoiceItem
{
    /** @var Money */
    private $amount;
    /** @var string */
    private $description;
    /** @var mixed */
    private $id;
    /** @var mixed */
    private $invoiceId;
    /** @var Product|null */
    private $product;
    /** @var bool */
    private $isTaxable;
    /** @var int */
    private $quantity;
    /** @var Money */
    private $totalAmount;

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function setAmount(Money $amount): InvoiceItem
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): InvoiceItem
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

    public function getInvoiceId()
    {
        return $this->invoiceId;
    }

    public function setInvoiceId($invoiceId)
    {
        $this->invoiceId = $invoiceId;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): InvoiceItem
    {
        $this->product = $product;

        return $this;
    }

    public function isTaxable(): bool
    {
        return $this->isTaxable;
    }

    public function setIsTaxable(bool $isTaxable): InvoiceItem
    {
        $this->isTaxable = $isTaxable;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): InvoiceItem
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getTotalAmount(): ?Money
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(Money $totalAmount): InvoiceItem
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }
}
