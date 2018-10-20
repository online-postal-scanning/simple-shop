<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Entity;

use DateTime;

final class Paid
{
    /** @var string */
    private $authorizationCode;
    /** @var CreditCard */
    private $card;
    /** @var DateTime */
    private $date;
    /** @var mixed */
    private $id;

    public function getAuthorizationCode(): string
    {
        return $this->authorizationCode;
    }

    public function setAuthorizationCode(string $authorizationCode): Paid
    {
        $this->authorizationCode = $authorizationCode;

        return $this;
    }

    public function getCard(): CreditCard
    {
        return $this->card;
    }

    public function setCard(CreditCard $card): Paid
    {
        $this->card = $card;

        return $this;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): Paid
    {
        $this->date = $date;

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
}