<?php
declare(strict_types=1);

namespace Tests\Functional\Interactor\DBal;

use Doctrine\DBAL\Connection;
use FunctionalTester;
use IamPersistent\SimpleShop\Entity\CreditCard;
use IamPersistent\SimpleShop\Interactor\DBal\InsertCard;

class InsertCardCest
{
    /** @var Connection */
    private $connection;
    /** @var InsertCard */
    private $insertCard;

    public function _before(FunctionalTester $I)
    {
        $this->connection = $I->getDBalConnection();
        $I->setUpDatabase();
        $this->insertCard = new InsertCard($this->connection);
    }

    public function testInsert(FunctionalTester $I)
    {
        $card = (new CreditCard())
            ->setCardNumber('4242424242424242')
            ->setCardReference('8675309')
            ->setOwnerId('42')
            ->setTitle('My Test Card');
        $this->insertCard->insert($card);
        $cardData = $this->connection->fetchAll('SELECT * FROM credit_cards');
        $I->assertEquals($this->expectedCardData(), $cardData);
    }

    private function expectedCardData(): array
    {
        return [
            [
                'card_number'    => 'XXXXXXXXXXXX4242',
                'card_reference' => '8675309',
                'id'             => '1',
                'owner_id'       => '42',
                'title'          => 'My Test Card',
            ],
        ];
    }
}
