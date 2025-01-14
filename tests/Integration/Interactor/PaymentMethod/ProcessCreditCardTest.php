<?php

namespace Tests\Integration\OLPS\SimpleShop\Interactor\PaymentMethod;

use DateTime;
use Money\Currency;
use Money\Money;
use OLPS\SimpleShop\Entity\CreditCard;
use OLPS\SimpleShop\Entity\PayumContext;
use OLPS\SimpleShop\Interactor\PaymentMethod\ProcessCreditCard;
use Payum\Core\Bridge\PlainPhp\Security\TokenFactory;
use Payum\Core\Model\Payment;
use Payum\Core\PayumBuilder;
use Payum\Core\Registry\SimpleRegistry;
use Payum\Core\Storage\FilesystemStorage;
use Payum\Offline\OfflineGatewayFactory;
use PHPUnit\Framework\TestCase;

class ProcessCreditCardTest extends TestCase
{
    public function testProcessCreditCard()
    {

        $storageDirectory = __DIR__ . '/../storage';
        $tokenStorage = new FilesystemStorage($storageDirectory, Payment::class);

        $offlineGatewayFactory = new OfflineGatewayFactory();

        $registry = new SimpleRegistry(
            [
                'offline' => $offlineGatewayFactory,
            ],
            [
                Payment::class => $tokenStorage,
            ],
            [
                'offline' => $offlineGatewayFactory,
            ]
        );
        $tokenFactory = new TokenFactory($tokenStorage, $registry, 'http://example.com');
//        $payum = new Payum($registry, new HttpRequestVerifier($tokenStorage), $tokenFactory, $tokenStorage);

        $payumBuilder = (new PayumBuilder())
            ->addGateway('simpleShop', [
                'factory' => 'offline',
            ])
            ->setTokenFactory($tokenFactory)
            ->setTokenStorage($tokenStorage)
            ->addStorage(Payment::class, new FilesystemStorage(sys_get_temp_dir(), Payment::class, 'number'))
        ;

        $payum = $payumBuilder->getPayum();

        $payumContext = new PayumContext(
            $payum,
        );

        $creditCard = (new CreditCard())
            ->setCardNumber('4111111111111111')
            ->setCardReference('cardReference')
            ->setExpirationDate(new DateTime('2025-12-31'))
            ->setNameOnCard('John Doe');

        $amount = new Money(1000, new Currency('USD'));

        $processCreditCard = new ProcessCreditCard($payumContext);
        $paid = $processCreditCard->handle($amount, $creditCard);
    }
}
