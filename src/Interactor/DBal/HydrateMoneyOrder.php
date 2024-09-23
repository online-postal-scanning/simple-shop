<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\DBal;

use DateTime;
use OLPS\SimpleShop\Entity\MoneyOrder;

final class HydrateMoneyOrder
{
    public function __invoke(array $moneyOrderData): MoneyOrder
    {
        $date = $moneyOrderData['date'] ? new DateTime($moneyOrderData['date']) : null;

        return (new MoneyOrder())
            ->setDate($date)
            ->setId($moneyOrderData['id'])
            ->setSerialNumber($moneyOrderData['serial_number']);
    }
}
