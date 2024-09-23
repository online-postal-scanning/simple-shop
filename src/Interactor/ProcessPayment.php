<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor;

use Exception;
use OLPS\SimpleShop\Entity\Invoice;
use OLPS\SimpleShop\Entity\PaymentMethodInterface;
use OLPS\SimpleShop\Exception\PaymentProcessingError;

final class ProcessPayment
{
    /** @var array */
    private $paymentProcessor;
    private $saveInvoice;

    public function __construct(SaveInvoiceInterface $saveInvoice, array $paymentProcessor)
    {
        $this->paymentProcessor = $paymentProcessor;
        $this->saveInvoice = $saveInvoice;
    }

    public function handle(Invoice $invoice, PaymentMethodInterface $paymentMethod)
    {
        /** @var \OLPS\SimpleShop\Interactor\ProcessPaymentInterface $method */
        $method = $this->paymentProcessor[$paymentMethod->getPaymentMethodType()];

        try {
            $paid = $method->handle($invoice->getTotal(), $paymentMethod);

            $invoice->setPaid($paid);
            $this->saveInvoice->save($invoice);
        } catch (Exception $e) {
            throw new PaymentProcessingError($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }
}
