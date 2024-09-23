<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\DBal;

use DateTime;
use OLPS\SimpleShop\Entity\CreditCard;

final class HydrateCreditCard
{
    public function __invoke(array $cardData): CreditCard
    {
        $sqlToBool = (new SQLToBool());

        return (new CreditCard())
            ->setActive($sqlToBool($cardData['active']))
            ->setBrand($cardData['brand'])
            ->setCardNumber($cardData['card_number'])
            ->setCardReference($cardData['card_reference'])
            ->setCity($cardData['city'])
            ->setCountry($cardData['country'])
            ->setExpirationDate(new DateTime($cardData['expiration_date']))
            ->setId($cardData['id'])
            ->setLastFour($cardData['last_four'])
            ->setNameOnCard($cardData['name_on_card'])
            ->setOwnerId($cardData['owner_id'])
            ->setPostCode($cardData['post_code'])
            ->setState($cardData['state'])
            ->setStreet1($cardData['street_1'])
            ->setStreet2($cardData['street_2'])
            ->setTitle($cardData['title']);
    }
}
