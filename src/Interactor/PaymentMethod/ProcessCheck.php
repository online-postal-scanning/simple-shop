<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\PaymentMethod;

use DateTime;
use IamPersistent\SimpleShop\Entity\Paid;
use IamPersistent\SimpleShop\Entity\PaymentMethodInterface;
use IamPersistent\SimpleShop\Interactor\InsertCheckInterface;
use IamPersistent\SimpleShop\Interactor\ProcessPaymentInterface;
use Money\Money;

final class ProcessCheck implements ProcessPaymentInterface
{
    /** @var \IamPersistent\SimpleShop\Interactor\InsertCheckInterface */
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
