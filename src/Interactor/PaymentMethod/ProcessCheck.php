<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\PaymentMethod;

use DateTime;
use OLPS\SimpleShop\Entity\Paid;
use OLPS\SimpleShop\Entity\PaymentMethodInterface;
use OLPS\SimpleShop\Interactor\InsertCheckInterface;
use OLPS\SimpleShop\Interactor\ProcessPaymentInterface;
use Money\Money;

final class ProcessCheck implements ProcessPaymentInterface
{
    /** @var \OLPS\SimpleShop\Interactor\InsertCheckInterface */
    private $insertCheck;

    public function __construct(InsertCheckInterface $insertCheck)
    {
        $this->insertCheck = $insertCheck;
    }

    public function handle(Money $amount, PaymentMethodInterface $check): Paid
    {
        $this->insertCheck->insert($check);

        return (new Paid())
            ->setAmount($amount)
            ->setPaymentMethod($check)
            ->setDate(new DateTime());
    }
}
