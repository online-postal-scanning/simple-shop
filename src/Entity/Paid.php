<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Entity;

use DateTime;
use Money\Money;

final class Paid
{
    /** @var Money */
    private $amount;
    /** @var string|null */
    private $authorizationCode;
    /** @var PaymentMethodInterface */
    private $paymentMethod;
    /** @var DateTime */
    private $date;
    /** @var mixed */
    private $id;

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function setAmount(Money $amount): Paid
    {
        $this->amount = $amount;

        return $this;
    }

    public function getAuthorizationCode(): ?string
    {
        return $this->authorizationCode;
    }

    public function setAuthorizationCode(string $authorizationCode): Paid
    {
        $this->authorizationCode = $authorizationCode;

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

    public function getPaymentMethod(): PaymentMethodInterface
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(PaymentMethodInterface $paymentMethod): Paid
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }
}
