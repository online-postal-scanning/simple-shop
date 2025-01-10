<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\DBal;

use OLPS\SimpleShop\Entity\CreditCard;
use OLPS\SimpleShop\Interactor\InsertCardInterface;
use GetOffMyCase\PascalCase;

final class InsertCard extends DBalCommon implements InsertCardInterface
{
    public function insert(CreditCard $creditCard): bool
    {
        $this->persist($creditCard);

        return true;
    }

    private function persist(CreditCard $creditCard)
    {
        $cardNumber = $creditCard->getCardNumber();
        $lastFour = substr($cardNumber, -4);
        $maskedNumber = str_repeat('X', strlen($cardNumber) - 4) . $lastFour;

        $data = [
            'brand'           => (new PascalCase)($creditCard->getBrand()),
            'card_number'     => $maskedNumber,
            'card_reference'  => $creditCard->getCardReference(),
            'city'            => $creditCard->getCity(),
            'country'         => $creditCard->getCountry(),
            'expiration_date' => $creditCard->getExpirationDate()->format('Y-m-d'),
            'is_active'       => $creditCard->isActive(),
            'last_four'       => $lastFour,
            'name_on_card'    => $creditCard->getNameOnCard(),
            'owner_id'        => $creditCard->getOwnerId(),
            'post_code'       => $creditCard->getPostCode(),
            'state'           => $creditCard->getState(),
            'street_1'        => $creditCard->getStreet1(),
            'street_2'        => $creditCard->getStreet2(),
            'title'           => $creditCard->getTitle(),
        ];

        $response = $this->connection->insert('credit_cards', $data);
        if (1 === $response) {
            $id = $this->connection->lastInsertId();
            $creditCard->setId($id);
            $creditCard->setLastFour($lastFour);
        }
    }
}
