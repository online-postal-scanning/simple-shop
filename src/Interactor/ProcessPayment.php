<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor;

use Exception;
use IamPersistent\SimpleShop\Entity\CreditCard;
use IamPersistent\SimpleShop\Entity\Invoice;
use IamPersistent\SimpleShop\Entity\Paid;
use IamPersistent\SimpleShop\Exception\PaymentProcessingError;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Omnipay\Common\GatewayInterface;

final class ProcessPayment
{
    private $gateway;
    private $moneyFormatter;

    public function __construct(GatewayInterface $gateway)
    {
        $this->gateway = $gateway;
        $this->moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());
    }

    public function handle(Invoice $invoice, CreditCard $card)
    {
        $amount = $invoice->getTotal();
        $options = $this->extractCreditCardOptions($card);
        $options['amount'] = $this->moneyFormatter->format($amount);

        try {
            $response = $this->gateway->purchase($options)->send();
            if ($response->isSuccessful()) {
                $paid = (new Paid());

                $invoice->setPaid($paid);
            } elseif ($response->isRedirect()) {
                $response->redirect();
            } else {
                throw new PaymentProcessingError($response->getMessage());
            }
        } catch (Exception $e) {
            throw new PaymentProcessingError('Sorry, there was an error processing your payment. Please try again later.', 0, $e);
        }
    }

    private function extractCreditCardOptions(CreditCard $card): array
    {
        if ($reference = $card->getCardReference()) {
            return ['cardReference' => $reference];
        }
    }
}