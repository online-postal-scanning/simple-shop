<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\PaymentMethod;

use DateTime;
use IamPersistent\SimpleShop\Entity\Paid;
use IamPersistent\SimpleShop\Entity\PaymentMethodInterface;
use IamPersistent\SimpleShop\Interactor\InsertMoneyOrderInterface;
use IamPersistent\SimpleShop\Interactor\ProcessPaymentInterface;
use Money\Money;

final class ProcessMoneyOrder implements ProcessPaymentInterface
{
    /** @var \IamPersistent\SimpleShop\Interactor\InsertMoneyOrderInterface */
    private $insertMoneyOrder;

    public function __construct(InsertMoneyOrderInterface $insertMoneyOrder)
    {
        $this->insertMoneyOrder = $insertMoneyOrder;
    }

    public function handle(Money $amount, PaymentMethodInterface $moneyOrder): Paid
    {
        $this->insertMoneyOrder->insert($moneyOrder);


        return (new Paid())
            ->setAmount($amount)
            ->setPaymentMethod($moneyOrder)
            ->setDate(new DateTime());
    }
}
