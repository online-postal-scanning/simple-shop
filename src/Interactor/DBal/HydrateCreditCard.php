<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\DBal;

use DateTime;
use IamPersistent\SimpleShop\Entity\CreditCard;

final class HydrateCreditCard
{
    public function __invoke(array $cardData): CreditCard
    {
        return (new CreditCard())
            ->setBrand($cardData['brand'])
            ->setCardNumber($cardData['card_number'])
            ->setCardReference($cardData['card_reference'])
            ->setExpirationDate(new DateTime($cardData['expiration_date']))
            ->setId($cardData['id'])
            ->setLastFour($cardData['last_four'])
            ->setOwnerId($cardData['owner_id'])
            ->setTitle($cardData['title']);
    }
}