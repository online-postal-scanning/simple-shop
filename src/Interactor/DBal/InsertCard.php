<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\DBal;

use IamPersistent\SimpleShop\Entity\CreditCard;
use IamPersistent\SimpleShop\Interactor\InsertCardInterface;
use Omnipay\Common\CreditCard as OmniCreditCard;

final class InsertCard extends DBalCommon implements InsertCardInterface
{
    public function insert(CreditCard $creditCard): bool
    {
        $this->persist($creditCard);

        return true;
    }

    private function persist(CreditCard $creditCard)
    {
        $omniCard = new OmniCreditCard(['number' => $creditCard->getCardNumber()]);

        $data = [
            'card_number' => $omniCard->getNumberMasked(),
            'expiration_date' => $creditCard->getExpirationDate()->format('Y-m-d'),
            'card_reference' => $creditCard->getCardReference(),
            'last_four' => $omniCard->getNumberLastFour(),
            'owner_id' => $creditCard->getOwnerId(),
            'title' => $creditCard->getTitle(),
        ];
        $response = $this->connection->insert('credit_cards', $data);
        if (1 === $response) {
            $id = $this->connection->lastInsertId();
            $creditCard->setId($id);
        } else {

        }
    }
}