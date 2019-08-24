<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Entity;

use DateTime;

final class CreditCard implements PaymentMethodInterface
{
    /** @var string */
    private $brand;
    /** @var string */
    private $cardNumber;
    /** @var string */
    private $cardReference;
    /** @var DateTime */
    private $expirationDate;
    /** @var mixed */
    private $id;
    /** @var string */
    private $lastFour;
    /** @var mixed */
    private $ownerId;
    /** @var string|null */
    private $title;

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): CreditCard
    {
        $this->brand = $brand;

        return $this;
    }

    public function getCardNumber(): string
    {
        return $this->cardNumber;
    }

    public function setCardNumber(string $cardNumber): CreditCard
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    public function getCardReference(): string
    {
        return $this->cardReference;
    }

    public function setCardReference(string $cardReference): CreditCard
    {
        $this->cardReference = $cardReference;

        return $this;
    }

    public function getDisplaySummary(): string
    {
        return ucfirst(strtolower($this->brand)) . ' * ' . $this->lastFour;
    }

    public function getExpirationDate(): DateTime
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(DateTime $expirationDate): CreditCard
    {
        $this->expirationDate = $expirationDate;

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

    public function getLastFour(): string
    {
        return $this->lastFour;
    }

    public function setLastFour(string $lastFour): CreditCard
    {
        $this->lastFour = $lastFour;

        return $this;
    }

    public function getOwnerId()
    {
        return $this->ownerId;
    }

    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;

        return $this;
    }

    public function getPaymentMethodType(): string
    {
        return 'creditCard';
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title = null): CreditCard
    {
        $this->title = $title;

        return $this;
    }
}
