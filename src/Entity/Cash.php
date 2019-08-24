<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Entity;

final class Cash implements PaymentMethodInterface
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
