<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\PaymentMethod;

use DateTime;
use IamPersistent\SimpleShop\Entity\Paid;
use IamPersistent\SimpleShop\Entity\PaymentMethodInterface;
use IamPersistent\SimpleShop\Interactor\ProcessPaymentInterface;
use Money\Money;

final class ProcessCash implements ProcessPaymentInterface
{
    public function handle(Money $amount, PaymentMethodInterface $cash): Paid
    {
        return (new Paid())
            ->setAmount($amount)
            ->setPaymentMethod($cash)
            ->setDate(new DateTime());
    }
}
