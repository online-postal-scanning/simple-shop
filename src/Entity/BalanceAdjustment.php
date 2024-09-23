<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Entity;

final class BalanceAdjustment implements PaymentMethodInterface
{
    public function getDisplaySummary(): string
    {
        return 'Balance Adjustment';
    }

    public function getId()
    {
        return 1;
    }

    public function getPaymentMethodType(): string
    {
        return 'balanceAdjustment';
    }
}
