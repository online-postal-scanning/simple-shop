<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\PaymentMethod;

use Exception;
use OLPS\SimpleShop\Entity\CreditCard;
use OLPS\SimpleShop\Entity\Paid;
use OLPS\SimpleShop\Entity\PaymentMethodInterface;
use OLPS\SimpleShop\Entity\PayumContext;
use OLPS\SimpleShop\Exception\PaymentProcessingError;
use OLPS\SimpleShop\Interactor\ProcessPaymentInterface;
use Money\Money;
use Payum\Core\Reply\HttpPostRedirect;
use Payum\Core\Reply\HttpRedirect;
use Payum\Core\Request\Capture;
use Payum\Core\Request\GetHumanStatus;

final class ProcessCreditCard implements ProcessPaymentInterface
{
    public function __construct(
        private readonly PayumContext $context,
    ) {
    }

    public function handle(Money $amount, CreditCard|PaymentMethodInterface $paymentMethod): Paid
    {
        try {
            $payment = $this->context->createPayment($amount, $paymentMethod);
            $gateway = $this->context->getGateway();

            if ($reply = $gateway->execute(new Capture($payment), true)) {
                if ($reply instanceof HttpRedirect) {
                    throw new PaymentProcessingError('Redirect not supported in this implementation');
                } elseif ($reply instanceof HttpPostRedirect) {
                    throw new PaymentProcessingError('Redirect not supported in this implementation');
                }

                throw new PaymentProcessingError("Unsupported reply: $reply");
            }
            $gateway->execute($status = new GetHumanStatus($payment));
            $firstModel = $status->getFirstModel();

            return (new Paid())
                ->setAmount($amount)
                ->setAuthorizationCode($firstModel->getNumber())
                ->setPaymentMethod($paymentMethod)
                ->setDate(new \DateTime());

        } catch (Exception $e) {
            throw new PaymentProcessingError($e->getMessage(), (int) $e->getCode(), $e->getPrevious());
        }
    }

    private function throwErrorFromResponse(RequestInterface $response): void
    {
        $message = "The payment gateway responded with: {$response->getStatus()}";
        throw new PaymentProcessingError($message, $response->getStatusCode());
    }
}
