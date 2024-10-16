<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Entity;

use DateTime;

class MoneyOrder implements PaymentMethodInterface
{
    /** @var DateTime|null */
    private $date;
    /** @var mixed */
    private $id;
    /** @var string|null */
    private $serialNumber;

    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    public function setDate(?DateTime $date): MoneyOrder
    {
        $this->date = $date;

        return $this;
    }

    public function getDisplaySummary(): string
    {
        return 'Money Order #' . $this->serialNumber;
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

    public function getPaymentMethodType(): string
    {
        return 'moneyOrder';
    }

    public function getSerialNumber(): ?string
    {
        return $this->serialNumber;
    }

    public function setSerialNumber(?string $serialNumber): MoneyOrder
    {
        $this->serialNumber = $serialNumber;

        return $this;
    }
}
