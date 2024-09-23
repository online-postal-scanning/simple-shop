<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\PaymentMethod;

use DateTime;
use OLPS\SimpleShop\Entity\Paid;
use OLPS\SimpleShop\Entity\PaymentMethodInterface;
use OLPS\SimpleShop\Interactor\InsertMoneyOrderInterface;
use OLPS\SimpleShop\Interactor\ProcessPaymentInterface;
use Money\Money;

final class ProcessMoneyOrder implements ProcessPaymentInterface
{
    /** @var \OLPS\SimpleShop\Interactor\InsertMoneyOrderInterface */
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
