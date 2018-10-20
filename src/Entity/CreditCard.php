<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Entity;

final class CreditCard
{
    /** @var string */
    private $cardNumber;
    /** @var string */
    private $cardReference;
    /** @var mixed */
    private $id;
    /** @var mixed */
    private $ownerId;
    /** @var string */
    private $title;

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

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): CreditCard
    {
        $this->title = $title;

        return $this;
    }
}