<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor;

use OLPS\SimpleShop\Entity\Paid;
use OLPS\SimpleShop\Entity\PaymentMethodInterface;
use Money\Money;

interface ProcessPaymentInterface
{
    public function handle(Money $amount, PaymentMethodInterface $paymentMethod): Paid;
}
