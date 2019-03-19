<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor;

use DateTime;
use IamPersistent\SimpleShop\Entity\CreditCard;
use IamPersistent\SimpleShop\Interactor\DBal\InsertCard;
use Omnipay\Common\CreditCard as OmniCreditCard;
use Omnipay\Common\GatewayInterface;
use Omnipay\Common\Message\ResponseInterface;

final class AuthorizeCard
{
    private $gateway;
    private $insertCard;
    private $response;

    public function __construct(GatewayInterface $gateway, InsertCard $insertCard)
    {
        $this->gateway = $gateway;
        $this->insertCard = $insertCard;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    public function handle(OmniCreditCard $omniCreditCard, $ownerId): ?CreditCard
    {
        $options = [
            'card' => $omniCreditCard,
        ];
        $this->response = $this->gateway->createCard($options)->send();

        if ($this->response->isSuccessful()) {
            $creditCard = (new CreditCard())
                ->setBrand($omniCreditCard->getBrand())
                ->setCardNumber($omniCreditCard->getNumberMasked())
                ->setCardReference($this->response->getCardReference())
                ->setExpirationDate(new DateTime($omniCreditCard->getExpiryDate('Y-m-y')))
                ->setLastFour($omniCreditCard->getNumberLastFour())
                ->setOwnerId($ownerId);
            $this->insertCard->insert($creditCard);

            return $creditCard;
        }

        return null;
    }
}