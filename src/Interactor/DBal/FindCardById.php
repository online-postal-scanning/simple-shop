<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\DBal;

use DateTime;
use IamPersistent\SimpleShop\Entity\CreditCard;
use IamPersistent\SimpleShop\Interactor\FindCardByIdInterface;

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