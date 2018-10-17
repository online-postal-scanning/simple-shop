<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Entity;

final class CreditCard
{
    /** @var string */
    private $cardReference;

    public function getCardReference(): string
    {
        return $this->cardReference;
    }

    public function setCardReference(string $cardReference): CreditCard
    {
        $this->cardReference = $cardReference;

        return $this;
    }
}