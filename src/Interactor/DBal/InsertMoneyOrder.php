<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\DBal;

use IamPersistent\SimpleShop\Entity\MoneyOrder;
use IamPersistent\SimpleShop\Interactor\InsertMoneyOrderInterface;

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
