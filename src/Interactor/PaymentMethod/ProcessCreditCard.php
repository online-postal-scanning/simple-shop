<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\PaymentMethod;

use DateTime;
use Exception;
use IamPersistent\SimpleShop\Entity\CreditCard;
use IamPersistent\SimpleShop\Entity\Paid;
use IamPersistent\SimpleShop\Entity\PaymentMethodInterface;
use IamPersistent\SimpleShop\Exception\PaymentProcessingError;
use IamPersistent\SimpleShop\Interactor\ProcessPaymentInterface;
use Money\Money;
use Omnipay\Common\GatewayInterface;
use Omnipay\Common\Message\ResponseInterface;

final class ProcessCreditCard implements ProcessPaymentInterface
{
    private $gateway;

    public function __construct(GatewayInterface $gateway)
    {
        $this->gateway = $gateway;
    }

    public function handle(Money $amount, PaymentMethodInterface $card): Paid
    {
        $options = $this->extractCreditCardOptions($card);
        $options['money'] = $amount;

        try {
            /** @var ResponseInterface $response */
            $response = $this->gateway->purchase($options)->send();
            if ($response->isSuccessful()) {
                return (new Paid())
                    ->setAmount($amount)
                    ->setAuthorizationCode($response->getCode())
                    ->setPaymentMethod($card)
                    ->setDate(new DateTime());
            } elseif ($response->isRedirect()) {
                $response->redirect();
            } else {
                throw new PaymentProcessingError($response->getMessage(), (int) $response->getCode());
            }
        } catch (Exception $e) {
            throw new PaymentProcessingError($e->getMessage(), (int) $e->getCode(), $e->getPrevious());
        }
    }

    private function extractCreditCardOptions(CreditCard $card): array
    {
        if ($reference = $card->getCardReference()) {
            return ['cardReference' => $reference];
        }
    }
}
