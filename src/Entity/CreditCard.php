<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Entity;

use DateTime;

class CreditCard implements PaymentMethodInterface
{
    /** @var bool */
    private $active;
    /** @var string */
    private $brand;
    /** @var string */
    private $cardNumber;
    /** @var string */
    private $cardReference;
    /** @var string|null */
    private $city;
    /** @var string|null */
    private $country;
    /** @var DateTime */
    private $expirationDate;
    /** @var mixed */
    private $id;
    /** @var string */
    private $lastFour;
    /** @var string|null */
    private $nameOnCard;
    /** @var mixed */
    private $ownerId;
    /** @var string|null */
    private $postCode;
    /** @var string|null */
    private $state;
    /** @var string|null */
    private $street1;
    /** @var string|null */
    private $street2;
    /** @var string|null */
    private $title;

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): CreditCard
    {
        $this->active = $active;

        return $this;
    }

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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): CreditCard
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): CreditCard
    {
        $this->country = $country;

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

    public function getNameOnCard(): ?string
    {
        return $this->nameOnCard;
    }

    public function setNameOnCard(?string $nameOnCard): CreditCard
    {
        $this->nameOnCard = $nameOnCard;

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

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public function setPostCode(?string $postCode): CreditCard
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): CreditCard
    {
        $this->state = $state;

        return $this;
    }

    public function getStreet1(): ?string
    {
        return $this->street1;
    }

    public function setStreet1(?string $street1): CreditCard
    {
        $this->street1 = $street1;

        return $this;
    }

    public function getStreet2(): ?string
    {
        return $this->street2;
    }

    public function setStreet2(?string $street2): CreditCard
    {
        $this->street2 = $street2;

        return $this;
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
