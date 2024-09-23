<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\DBal;

use OLPS\SimpleShop\Entity\MoneyOrder;
use OLPS\SimpleShop\Interactor\InsertMoneyOrderInterface;

final class InsertMoneyOrder extends DBalCommon implements InsertMoneyOrderInterface
{
    public function insert(MoneyOrder $moneyOrder): bool
    {
        $this->persist($moneyOrder);

        return true;
    }

    private function persist(MoneyOrder $moneyOrder)
    {
        $date = $moneyOrder->getDate() ? $moneyOrder->getDate()->format('Y-m-d') : null;
        $data = [
            'date'         => $date,
            'serial_number' => $moneyOrder->getSerialNumber(),
        ];
        $response = $this->connection->insert('money_orders', $data);
        if (1 === $response) {
            $id = $this->connection->lastInsertId();
            $moneyOrder->setId($id);
        } else {

        }
    }
}
