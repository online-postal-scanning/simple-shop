<?php

declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor;

use OLPS\SimpleShop\Entity\CreditCard;
use OLPS\SimpleShop\Entity\PayumContext;
use OLPS\SimpleShop\Interactor\InsertCardInterface;
use Payum\Core\Model\CreditCard as PayumCreditCard;
use Payum\Core\Request\Authorize;

final class AuthorizeCard
{
    private $payumContext;
    private $insertCard;
    private $response;

    public function __construct(PayumContext $payumContext, InsertCardInterface $insertCard)
    {
        $this->payumContext = $payumContext;
        $this->insertCard = $insertCard;
    }

    public function getResponse(): ?object
    {
        return $this->response;
    }

    public function handle(PayumCreditCard $payumCreditCard, $ownerId): ?CreditCard
    {
        try {
            $authorize = new Authorize($payumCreditCard);
            $this->payumContext->getGateway()->execute($authorize);

            if ($authorize->getModel() === $payumCreditCard) {
                $fullName = $payumCreditCard->getHolder();
                $creditCard = (new CreditCard())
                    ->setActive(true)
                    ->setBrand($payumCreditCard->getBrand())
                    ->setCardNumber($payumCreditCard->getMaskedNumber())
                    ->setCardReference($payumCreditCard->getToken())
                    ->setExpirationDate($payumCreditCard->getExpireAt())
                    ->setLastFour(substr($payumCreditCard->getMaskedNumber(), -4))
                    ->setNameOnCard($fullName)
                    ->setOwnerId($ownerId);
                $this->insertCard->insert($creditCard);

                return $creditCard;
            }
        } catch (\Exception $e) {
            // Authorization failed
        }

        return null;
    }
}
