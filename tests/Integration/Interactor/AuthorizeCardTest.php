<?php

namespace Tests\Integration\OLPS\SimpleShop\Interactor;

use DateTime;
use OLPS\SimpleShop\Entity\CreditCard;
use OLPS\SimpleShop\Entity\PayumContext;
use OLPS\SimpleShop\Interactor\AuthorizeCard;
use OLPS\SimpleShop\Interactor\InsertCardInterface;
use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\PlainPhp\Security\TokenFactory;
use Payum\Core\Model\CreditCard as PayumCreditCard;
use Payum\Core\Model\Payment;
use Payum\Core\PayumBuilder;
use Payum\Core\Registry\SimpleRegistry;
use Payum\Core\Request\Authorize;
use Payum\Core\Request\Generic;
use Payum\Core\Storage\FilesystemStorage;
use Payum\Offline\OfflineGatewayFactory;
use PHPUnit\Framework\TestCase;


class AuthorizeCardTest extends TestCase
{
    private PayumContext $payumContext;
    private TestInsertCard $insertCard;

    protected function setUp(): void
    {
        $storageDirectory = sys_get_temp_dir();
        $tokenStorage = new FilesystemStorage($storageDirectory, Payment::class);

        $offlineGatewayFactory = new OfflineGatewayFactory();
        $gateway = $offlineGatewayFactory->create();
        $gateway->addAction(new TestAuthorizeAction());

        $registry = new SimpleRegistry(
            [
                'simpleShop' => $gateway,
            ],
            [
                Payment::class => $tokenStorage,
            ],
            [
                'simpleShop' => $gateway,
            ]
        );
        $tokenFactory = new TokenFactory($tokenStorage, $registry, 'http://example.com');

        $payumBuilder = (new PayumBuilder())
            ->addGateway('simpleShop', [
                'factory' => 'offline',
            ])
            ->setTokenFactory($tokenFactory)
            ->setTokenStorage($tokenStorage)
            ->addStorage(Payment::class, new FilesystemStorage($storageDirectory, Payment::class, 'number'))
        ;

        $payum = $payumBuilder->getPayum();
        $payum->getGateway('simpleShop')->addAction(new TestAuthorizeAction());

        $this->payumContext = new PayumContext($payum);
        $this->insertCard = new TestInsertCard();
    }

    public function testAuthorizeCard()
    {
        $payumCard = new PayumCreditCard();
        $payumCard->setToken('token123');
        $payumCard->setMaskedNumber('411111******1111');
        $payumCard->setHolder('John Doe');
        $payumCard->setExpireAt(new DateTime('2025-12-31'));
        $payumCard->setBrand('visa');

        $ownerId = 'user123';

        $authorizeCard = new AuthorizeCard($this->payumContext, $this->insertCard);
        $result = $authorizeCard->handle($payumCard, $ownerId);

        $this->assertInstanceOf(CreditCard::class, $result);
        $this->assertEquals('token123', $result->getCardReference());
        $this->assertEquals('411111******1111', $result->getCardNumber());
        $this->assertEquals('John Doe', $result->getNameOnCard());
        $this->assertEquals('2025-12-31', $result->getExpirationDate()->format('Y-m-d'));
        $this->assertEquals('visa', $result->getBrand());
        $this->assertEquals($ownerId, $result->getOwnerId());
        $this->assertEquals('1111', $result->getLastFour());
        $this->assertTrue($result->isActive());

        // Verify the card was inserted
        $insertedCard = $this->insertCard->getLastInsertedCard();
        $this->assertNotNull($insertedCard);
        $this->assertEquals($result->getCardReference(), $insertedCard->getCardReference());
    }

    public function testAuthorizeCardFailure()
    {
        $payumCard = new PayumCreditCard();
        // Not setting required fields to simulate failure

        $authorizeCard = new AuthorizeCard($this->payumContext, $this->insertCard);
        $result = $authorizeCard->handle($payumCard, 'user123');

        $this->assertNull($result);
        $this->assertNull($this->insertCard->getLastInsertedCard());
    }
}

class TestAuthorizeAction implements ActionInterface
{
    public function execute($request): void
    {
        /** @var Authorize $request */
        $model = $request->getModel();
        // For successful test, do nothing
        // For failure test, throw an exception if the card is not properly set up
        if (!$model instanceof PayumCreditCard || !$model->getToken()) {
            throw new \Exception('Card not properly configured');
        }
    }

    public function supports($request): bool
    {
        return $request instanceof Authorize 
            && $request->getModel() instanceof PayumCreditCard;
    }
}

class TestInsertCard implements InsertCardInterface
{
    private ?CreditCard $lastInsertedCard = null;
    
    public function insert(CreditCard $creditCard): bool
    {
        $this->lastInsertedCard = $creditCard;
        return true;
    }
    
    public function getLastInsertedCard(): ?CreditCard
    {
        return $this->lastInsertedCard;
    }
}
