<?php
declare(strict_types=1);

namespace Tests\Functional\Interactor\DBal;

use DateTime;
use Doctrine\DBAL\Connection;
use OLPS\SimpleShop\Entity\CreditCard;
use OLPS\SimpleShop\Interactor\DBal\FindCardById;

class FindCardByIdCest
{
    /** @var Connection */
    private $connection;
    /** @var FindCardById */
    private $findCardById;

    public function _after(FunctionalTester $I)
    {
        $I->dropDatabase();
    }

    public function _before(FunctionalTester $I)
    {
        $this->connection = $I->getDBalConnection();
        $I->setUpDatabase();
        $this->findCardById = new FindCardById($this->connection);
    }

    public function testFind(FunctionalTester $I)
    {
        $this->connection->insert('credit_cards', $this->cardData());

        $creditCard = $this->findCardById->find(1);

        $I->assertEquals($this->expectedCreditCard(), $creditCard);
    }

    private function cardData(): array
    {
        return [
            'active'          => 0,
            'brand'           => 'Visa',
            'card_number'     => 'XXXXXXXXXXXX4242',
            'card_reference'  => '8675309',
            'city'            => 'Madras',
            'country'         => 'US',
            'expiration_date' => '2018-10-01',
            'id'              => '1',
            'last_four'       => '4242',
            'name_on_card'    => 'Jane Doe',
            'owner_id'        => '42',
            'post_code'       => '97741',
            'state'           => 'OR',
            'street_1'        => '9253 NW Mecca Rd',
            'street_2'        => 'Site 3',
            'title'           => 'My Test Card',
        ];
    }

    private function expectedCreditCard(): CreditCard
    {
        return (new CreditCard())
            ->setActive(false)
            ->setBrand('Visa')
            ->setCardNumber('XXXXXXXXXXXX4242')
            ->setCardReference('8675309')
            ->setCity('Madras')
            ->setCountry('US')
            ->setExpirationDate(new DateTime('2018-10-01'))
            ->setId(1)
            ->setLastFour('4242')
            ->setNameOnCard('Jane Doe')
            ->setOwnerId('42')
            ->setPostCode('97741')
            ->setState('OR')
            ->setStreet1('9253 NW Mecca Rd')
            ->setStreet2('Site 3')
            ->setTitle('My Test Card');
    }
}
