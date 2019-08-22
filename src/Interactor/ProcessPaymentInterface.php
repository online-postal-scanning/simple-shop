<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor;

use IamPersistent\SimpleShop\Entity\Paid;
use IamPersistent\SimpleShop\Entity\PaymentMethodInterface;
use Money\Money;

interface ProcessPaymentInterface
{
    public function handle(Money $amount, PaymentMethodInterface $card): Paid;
}
