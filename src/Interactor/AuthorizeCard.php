<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor;

use DateTime;
use IamPersistent\SimpleShop\Entity\CreditCard;
use IamPersistent\SimpleShop\Interactor\DBal\InsertCard;
use Omnipay\Common\CreditCard as OmniCreditCard;
use Omnipay\Common\GatewayInterface;

final class AuthorizeCard
{
    private $gateway;
    private $insertCard;

    public function __construct(GatewayInterface $gateway, InsertCard $insertCard)
    {
        $this->gateway = $gateway;
        $this->insertCard = $insertCard;
    }

    public function handle(OmniCreditCard $omniCreditCard, $ownerId): CreditCard
    {
        $options = [
            'card' => $omniCreditCard,
        ];
        $response = $this->gateway->createCard($options)->send();

        if ($response->isSuccessful()) {
            $creditCard = (new CreditCard())
                ->setCardNumber($omniCreditCard->getNumberMasked())
                ->setCardReference($response->getCardReference())
                ->setExpirationDate(new DateTime($omniCreditCard->getExpiryDate('Y-m-y')))
                ->setOwnerId($ownerId);
            $this->insertCard->insert($creditCard);

            return $creditCard;
        }

    }
}