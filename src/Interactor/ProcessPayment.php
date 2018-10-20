<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor;

use DateTime;
use Exception;
use IamPersistent\SimpleShop\Entity\CreditCard;
use IamPersistent\SimpleShop\Entity\Invoice;
use IamPersistent\SimpleShop\Entity\Paid;
use IamPersistent\SimpleShop\Exception\PaymentProcessingError;
use IamPersistent\SimpleShop\Interactor\DBal\InsertInvoice;
use Omnipay\Common\GatewayInterface;
use Omnipay\SmartPayments\Message\PurchaseResponse;

final class ProcessPayment
{
    private $gateway;
    private $insertInvoice;

    public function __construct(GatewayInterface $gateway, InsertInvoice $insertInvoice)
    {
        $this->gateway = $gateway;
        $this->insertInvoice = $insertInvoice;
    }

    public function handle(Invoice $invoice, CreditCard $card)
    {
        $total = $invoice->getTotal();
        $options = $this->extractCreditCardOptions($card);
        $options['amount'] = $total;

        try {
            /** @var PurchaseResponse $response */
            $response = $this->gateway->purchase($options)->send();
            if ($response->isSuccessful()) {
                $paid = (new Paid())
                    ->setAmount($total)
                    ->setAuthorizationCode($response->getAuthorizationCode())
                    ->setCard($card)
                    ->setDate(new DateTime());
                $invoice->setPaid($paid);
                $this->insertInvoice->insert($invoice);
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