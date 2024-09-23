<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Entity;

interface PaymentMethodInterface
{
    public function getDisplaySummary(): string;
    public function getId();
    public function getPaymentMethodType(): string;
}
