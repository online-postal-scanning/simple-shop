<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\PaymentMethod;

use DateTime;
use Exception;
use OLPS\SimpleShop\Entity\CreditCard;
use OLPS\SimpleShop\Entity\Paid;
use OLPS\SimpleShop\Entity\PaymentMethodInterface;
use OLPS\SimpleShop\Exception\PaymentProcessingError;
use OLPS\SimpleShop\Interactor\ProcessPaymentInterface;
use Money\Money;
use Omnipay\Common\GatewayInterface;
use Omnipay\Common\Message\ResponseInterface;

final class ProcessCreditCard implements ProcessPaymentInterface
{
    public function __construct(
        private GatewayInterface $gateway,
    ) {
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
                $this->throwErrorFromResponse($response);
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

    private function throwErrorFromResponse(ResponseInterface $response): void
    {
        $message = "The bank responsed with: {$response->getMessage()}";
        throw new PaymentProcessingError($message, (int) $response->getCode());
    }
}