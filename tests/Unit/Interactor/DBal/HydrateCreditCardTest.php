<?php
declare(strict_types=1);

namespace Tests\Unit\OLPS\SimpleShop\Interactor\DBal;

use DateTime;
use OLPS\SimpleShop\Entity\CreditCard;
use OLPS\SimpleShop\Interactor\DBal\HydrateCreditCard;
use PHPUnit\Framework\TestCase;

class HydrateCreditCardTest extends TestCase
{
    public function testInvoke()
    {
        $creditCardData = [
            'active' => 1,
            'brand' => 'Visa',
            'card_number' => '************4242',
            'card_reference' => '8675309',
            'expiration_date' => '2022-04-01',
            'id' => 42,
            'city' => 'San Fransisco',
            'country' => 'US',
            'name_on_card' => 'Joseph',
            'post_code' => '33235',
            'last_four' => '4242',
            'state' => 'CA',
            'street_1' => '9253 NW Mecca Rd',
            'street_2' => '',
            'owner_id' => 1,
            'title' => 'Debit Card',
        ];

        $hydrateCreditCard = new HydrateCreditCard();
        $creditCard = $hydrateCreditCard($creditCardData);

        $this->assertEquals($this->expectedCreditCard(), $creditCard);
    }

    private function expectedCreditCard(): CreditCard
    {
        return (new CreditCard())
            ->setActive(true)
            ->setBrand('Visa')
            ->setCardNumber('************4242')
            ->setCardReference('8675309')
            ->setExpirationDate(new DateTime('2022-04-01'))
            ->setCity('San Fransisco')
            ->setCountry('US')
            ->setNameOnCard('Joseph')
            ->setStreet1('9253 NW Mecca Rd')
            ->setStreet2('')
            ->setPostCode('33235')
            ->setState('CA')
            ->setId(42)
            ->setLastFour('4242')
            ->setOwnerId(1)
            ->setTitle('Debit Card');
    }
}
