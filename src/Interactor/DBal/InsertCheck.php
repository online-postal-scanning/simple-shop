<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\DBal;

use OLPS\SimpleShop\Entity\Check;
use OLPS\SimpleShop\Interactor\InsertCheckInterface;

final class InsertCheck extends DBalCommon implements InsertCheckInterface
{
    public function insert(Check $check): bool
    {
        $this->persist($check);

        return true;
    }

    private function persist(Check $check)
    {
        $date = $check->getDate() ? $check->getDate()->format('Y-m-d') : null;
        $data = [
            'check_number' => $check->getCheckNumber(),
            'date'         => $date,
        ];
        $response = $this->connection->insert('checks', $data);
        if (1 === $response) {
            $id = $this->connection->lastInsertId();
            $check->setId($id);
        } else {

        }
    }
}
