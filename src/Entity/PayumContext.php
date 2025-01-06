<?php

declare(strict_types=1);

namespace OLPS\SimpleShop\Entity;

use Money\Money;
use Payum\Core\GatewayInterface;
use Payum\Core\Model\CreditCard as PayumCreditCard;
use Payum\Core\Model\Payment;
use Payum\Core\Payum;
use Payum\Core\Security\GenericTokenFactoryInterface;
use Payum\Core\Security\TokenInterface;
use Payum\Core\Storage\StorageInterface;

class PayumContext
{
    const GATEWAY_NAME = 'simpleShop';
    
    public function __construct(
        private Payum $payum,
    ) {
    }

    public function createAuthorizeToken($model, $afterPath, array $afterParameters = []): TokenInterface
    {
        return $this->payum->getTokenFactory()->createAuthorizeToken(
            self::GATEWAY_NAME,
            $model,
            $afterPath,
            $afterParameters
        );
    }

    public function createCaptureToken($model, $afterPath, array $afterParameters = []): TokenInterface
    {
        return $this->payum->getTokenFactory()->createCaptureToken(
            self::GATEWAY_NAME,
            $model,
            $afterPath,
            $afterParameters,
        );
    }

    public function createNotifyToken($model = null): TokenInterface
    {
        return $this->payum->getTokenFactory()->createNotifyToken(
            self::GATEWAY_NAME,
            $model
        );
    }

    public function createPayment(Money $amount, CreditCard $creditCard): object
    {
        $storage = $this->getStorage(Payment::class);

        /** @var Payment $payment */
        $payment = $storage->create();
        $payment->setNumber(uniqid());
        $payment->setCurrencyCode($amount->getCurrency()->getCode());
        $payment->setTotalAmount($amount->getAmount());
        $payment->setDescription('Credit card payment');
        $payment->setClientId($creditCard->getOwnerId());
        $payment->setCreditCard($this->convertCreditCard($creditCard));

        $storage->update($payment);

        return $payment;
    }

    public function createPayoutToken($model, $afterPath, array $afterParameters = []): TokenInterface
    {
        return $this->payum->getTokenFactory()->createPayoutToken(
            self::GATEWAY_NAME,
            $model,
            $afterPath,
            $afterParameters
        );
    }

    public function createRefundToken($model, $afterPath = null, array $afterParameters = []): TokenInterface
    {
        return $this->payum->getTokenFactory()->createRefundToken(
            self::GATEWAY_NAME,
            $model,
            $afterPath,
            $afterParameters
        );
    }

    public function getPayum(): Payum
    {
        return $this->payum;
    }

    public function getGateway(): GatewayInterface
    {
        return $this->payum->getGateway(self::GATEWAY_NAME);
    }

    public function getGatewayName(): string
    {
        return self::GATEWAY_NAME;
    }

    public function getStorage(string $class): StorageInterface
    {
        return $this->payum->getStorage($class);
    }

    public function getTokenFactory(): GenericTokenFactoryInterface
    {
        return $this->payum->getTokenFactory();
    }

    protected function convertCreditCard(CreditCard $creditCard): PayumCreditCard
    {
        $payumCreditCard = new PayumCreditCard();
        $payumCreditCard->setToken($creditCard->getCardReference());
        $payumCreditCard->setMaskedNumber($creditCard->getCardNumber());
        $payumCreditCard->setHolder($creditCard->getNameOnCard());
        $payumCreditCard->setExpireAt($creditCard->getExpirationDate());

        return $payumCreditCard;
    }
}
