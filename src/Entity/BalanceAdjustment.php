<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Entity;

final class BalanceAdjustment implements PaymentMethodInterface
{
    public function getId()
    {
        return 1;
    }

    public function getPaymentMethodType(): string
    {
        return 'balanceAdjustment';
    }
}
