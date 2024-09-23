<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\PaymentMethod;

use DateTime;
use OLPS\SimpleShop\Entity\Paid;
use OLPS\SimpleShop\Entity\PaymentMethodInterface;
use OLPS\SimpleShop\Interactor\ProcessPaymentInterface;
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
