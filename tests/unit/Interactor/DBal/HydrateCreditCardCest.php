<?php
declare(strict_types=1);

namespace Tests\Unit\Interactor\DBal;

use DateTime;
use IamPersistent\SimpleShop\Entity\CreditCard;
use IamPersistent\SimpleShop\Interactor\DBal\HydrateCreditCard;
use UnitTester;

class HydrateCreditCardCest
{
    public function test__invoke(UnitTester $I)
    {
        $creditCardData = [
            'active'          => 1,
            'brand'           => 'Visa',
            'card_number'     => '************4242',
            'card_reference'  => '8675309',
            'expiration_date' => '2022-04-01',
            'id'              => 42,
            'last_four'       => '4242',
            'owner_id'        => 1,
            'title'           => 'Debit Card',
        ];
        $creditCard = (new HydrateCreditCard())($creditCardData);
        $I->assertEquals($this->expectedCreditCard(), $creditCard);
    }

    private function expectedCreditCard(): CreditCard
    {
        return (new CreditCard())
            ->setActive(true)
            ->setBrand('Visa')
            ->setCardNumber('************4242')
            ->setCardReference('8675309')
            ->setExpirationDate(new DateTime('2022-04-01'))
            ->setId(42)
            ->setLastFour('4242')
            ->setOwnerId(1)
            ->setTitle('Debit Card');
    }
}
