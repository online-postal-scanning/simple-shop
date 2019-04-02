<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Entity;

interface PaymentMethodInterface
{
    public function getPaymentMethodType(): string;
}
