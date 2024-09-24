<?php
declare(strict_types=1);

namespace Tests\Functional\Interactor\DBal;

use DateTime;
use Doctrine\DBAL\Connection;
use OLPS\SimpleShop\Entity\CreditCard;
use OLPS\SimpleShop\Interactor\DBal\InsertCard;

class InsertCardCest
{
    /** @var Connection */
    private $connection;
    /** @var InsertCard */
    private $insertCard;

    public function _after(FunctionalTester $I)
    {
        $I->dropDatabase();
    }

    public function _before(FunctionalTester $I)
    {
        $this->connection = $I->getDBalConnection();
        $I->setUpDatabase();
        $this->insertCard = new InsertCard($this->connection);
    }

    public function testInsert(FunctionalTester $I)
    {
        $card = (new CreditCard())
          ->setActive(true)
          ->setBrand('Visa')
          ->setCardNumber('4242424242424242')
          ->setCardReference('8675309')
          ->setCity('Madras')
          ->setCountry('US')
          ->setExpirationDate(new DateTime('2018-10-01'))
          ->setNameOnCard('Jane Doe')
          ->setOwnerId('42')
          ->setPostCode('97741')
          ->setState('OR')
          ->setStreet1('9253 NW Mecca Rd')
          ->setTitle('My Test Card');
        $this->insertCard->insert($card);
        $cardData = $this->connection->fetchAllAssociative('SELECT * FROM credit_cards');
        $I->assertEquals($this->expectedCardData(), $cardData);
    }

    private function expectedCardData(): array
    {
        return [
          [
            'active' => '1',
            'brand' => 'Visa',
            'card_number' => 'XXXXXXXXXXXX4242',
            'card_reference' => '8675309',
            'city' => 'Madras',
            'country' => 'US',
            'expiration_date' => '2018-10-01',
            'id' => '1',
            'last_four' => '4242',
            'name_on_card' => 'Jane Doe',
            'owner_id' => '42',
            'post_code' => '97741',
            'state' => 'OR',
            'street_1' => '9253 NW Mecca Rd',
            'street_2' => '',
            'title' => 'My Test Card',
          ]
        ];
    }
}
