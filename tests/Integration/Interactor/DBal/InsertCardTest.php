<?php
declare(strict_types=1);

namespace Tests\Integration\Interactor\DBal;

use DateTime;
use OLPS\SimpleShop\Entity\CreditCard;
use OLPS\SimpleShop\Interactor\DBal\InsertCard;
use Tests\Integration\IntegrationTestCase;

class InsertCardTest extends IntegrationTestCase
{
    private InsertCard $insertCard;

    protected function setUp(): void
    {
        parent::setUp();

        $this->insertCard = new InsertCard(self::$connection);
    }

    public function testInsert(): void
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
            ->setOwnerId(42)
            ->setPostCode('97741')
            ->setState('OR')
            ->setStreet1('9253 NW Mecca Rd')
            ->setTitle('My Test Card');

        $this->insertCard->insert($card);
        
        $cardData = self::$connection->fetchAllAssociative('SELECT * FROM credit_cards');
        $this->assertEquals($this->expectedCardData(), $cardData);
    }

    private function expectedCardData(): array
    {
        return [
            [
                'brand' => 'Visa',
                'card_number' => 'XXXXXXXXXXXX4242',
                'card_reference' => '8675309',
                'city' => 'Madras',
                'country' => 'US',
                'expiration_date' => '2018-10-01',
                'id' => 1,
                'is_active' => 1,
                'last_four' => '4242',
                'name_on_card' => 'Jane Doe',
                'owner_id' => 42,
                'post_code' => '97741',
                'state' => 'OR',
                'street_1' => '9253 NW Mecca Rd',
                'street_2' => '',
                'title' => 'My Test Card',
            ]
        ];
    }
}
