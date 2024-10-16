<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Entity;

class Cash implements PaymentMethodInterface
{
    public function getDisplaySummary(): string
    {
        return 'Cash';
    }

    public function getId()
    {
        return 1;
    }

    public function getPaymentMethodType(): string
    {
        return 'cash';
    }
}
