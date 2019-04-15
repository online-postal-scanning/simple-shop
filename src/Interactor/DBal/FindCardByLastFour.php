<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\DBal;

use IamPersistent\SimpleShop\Entity\CreditCard;
use IamPersistent\SimpleShop\Interactor\FindCardByLastFourInterface;

final class FindCardByLastFour extends DBalCommon implements FindCardByLastFourInterface
{
    public function find($lastFour): ?CreditCard
    {
        $statement = $this->connection->executeQuery("SELECT * FROM credit_cards WHERE last_four LIKE '%$lastFour'");
        $cardData = $statement->fetch();
        if (empty($cardData)) {
            return null;
        }

        return (new HydrateCreditCard())($cardData);
    }
}
