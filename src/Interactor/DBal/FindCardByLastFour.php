<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\DBal;

use OLPS\SimpleShop\Entity\CreditCard;
use OLPS\SimpleShop\Interactor\FindCardByLastFourInterface;

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
