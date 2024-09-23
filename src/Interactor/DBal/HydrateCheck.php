<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\DBal;

use DateTime;
use OLPS\SimpleShop\Entity\Check;

final class HydrateCheck
{
    public function __invoke(array $checkData): Check
    {
        $date = $checkData['date'] ? new DateTime($checkData['date']) : null;

        return (new Check())
            ->setCheckNumber($checkData['check_number'])
            ->setDate($date)
            ->setId($checkData['id']);
    }
}
