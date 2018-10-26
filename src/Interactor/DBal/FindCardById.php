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

        return (new CreditCard())
            ->setCardNumber($cardData['card_number'])
            ->setCardReference($cardData['card_reference'])
            ->setExpirationDate(new DateTime($cardData['expiration_date']))
            ->setId($cardData['id'])
            ->setLastFour($cardData['last_four'])
            ->setOwnerId($cardData['owner_id'])
            ->setTitle($cardData['title']);
    }
}