<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Entity;

use Money\Money;

class FeeItem extends InvoiceItem
{
    private Money $calculatedAmount;

    public function __construct(
        private string $feePercentage,
        private ?Money $baseFee = null,
    ) {
    }

    public function getAmount(): Money
    {
        return $this->calculatedAmount;
    }

    public function getQuantity(): ?int
    {
        return 1;
    }

    public function getTotalAmount(): ?Money
    {
        return $this->calculatedAmount;
    }

    public function calculate(Money $subTotal): void
    {
        $amount = $subTotal->multiply($this->feePercentage);
        if ($this->baseFee) {
            $amount = $amount->add($this->baseFee);
        }
        $this->calculatedAmount = $amount;
    }
}
