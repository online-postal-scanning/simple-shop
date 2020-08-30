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
            $fullName = implode(' ', [$omniCreditCard->getFirstName(), $omniCreditCard->getLastName()]);
            $creditCard = (new CreditCard())
                ->setActive(true)
                ->setBrand($omniCreditCard->getBrand())
                ->setCardNumber($omniCreditCard->getNumberMasked())
                ->setCardReference($this->response->getCardReference())
                ->setCity($omniCreditCard->getBillingCity())
                ->setCountry($omniCreditCard->getBillingCountry())
                ->setExpirationDate(new DateTime($omniCreditCard->getExpiryDate('Y-m-y')))
                ->setLastFour($omniCreditCard->getNumberLastFour())
                ->setNameOnCard($fullName)
                ->setOwnerId($ownerId)
                ->setPostCode($omniCreditCard->getBillingPostcode())
                ->setState($omniCreditCard->getBillingState())
                ->setStreet1($omniCreditCard->getBillingAddress1())
                ->setStreet2($omniCreditCard->getBillingAddress2());
            $this->insertCard->insert($creditCard);

            return $creditCard;
        }

        return null;
    }
}
