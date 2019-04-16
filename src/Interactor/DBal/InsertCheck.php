<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\DBal;

use IamPersistent\SimpleShop\Entity\Check;
use IamPersistent\SimpleShop\Interactor\InsertCheckInterface;

final class InsertCheck extends DBalCommon implements InsertCheckInterface
{
    public function insert(Check $check): bool
    {
        $this->persist($check);

        return true;
    }

    private function persist(Check $check)
    {
        $data = [
            'check_number' => $check->getCheckNumber(),
            'date' => $check->getDate()->format('Y-m-d'),
        ];
        $response = $this->connection->insert('checks', $data);
        if (1 === $response) {
            $id = $this->connection->lastInsertId();
            $check->setId($id);
        } else {

        }
    }
}
