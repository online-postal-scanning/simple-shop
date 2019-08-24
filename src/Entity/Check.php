<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Entity;

use DateTime;

final class Check implements PaymentMethodInterface
{
    /** @var string|null */
    private $checkNumber;
    /** @var DateTime|null */
    private $date;
    /** @var mixed */
    private $id;

    public function getCheckNumber(): ?string
    {
        return $this->checkNumber;
    }

    public function setCheckNumber(?string $checkNumber): Check
    {
        $this->checkNumber = $checkNumber;

        return $this;
    }

    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    public function setDate(?DateTime $date): Check
    {
        $this->date = $date;

        return $this;
    }

    public function getDisplaySummary(): string
    {
        return 'Check #' . $this->checkNumber;
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
        return 'check';
    }
}
