<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\DBal;

use DateTime;
use OLPS\SimpleShop\Entity\CreditCard;
use OLPS\SimpleShop\Interactor\FindCardByIdInterface;

final class FindCardById extends DBalCommon implements FindCardByIdInterface
{
    public function find($id): ?CreditCard
    {
        $statement = $this->connection->executeQuery('SELECT * FROM credit_cards WHERE id ='. $id);
        $cardData = $statement->fetch();
        if (empty($cardData)) {
            return null;
        }

        return (new HydrateCreditCard())($cardData);
    }
}
