<?php

declare(strict_types=1);

namespace Tests\Unit\Interactor;

use IamPersistent\SimpleShop\Interactor\ExtractExpirationDate;

use UnitTester;

class ExtractExpirationDateCest
{
    public function testSeparatingCharacter(UnitTester $I)
    {
        $date = (new ExtractExpirationDate)('3-19');

        $I->assertEquals(['month' => '03', 'year' => '19'], $date);
    }

    public function testSeparatingCharacterNoLeadingZero(UnitTester $I)
    {
        $date = (new ExtractExpirationDate)('03-19');

        $I->assertEquals(['month' => '03', 'year' => '19'], $date);
    }

    public function testSeparatingCharacterFourDigitYear(UnitTester $I)
    {
        $date = (new ExtractExpirationDate)('11/2020');

        $I->assertEquals(['month' => '11', 'year' => '20'], $date);
    }

    public function testThreeDigit(UnitTester $I)
    {
        $date = (new ExtractExpirationDate)('319');

        $I->assertEquals(['month' => '03', 'year' => '19'], $date);
    }

    public function testFourDigit(UnitTester $I)
    {
        $date = (new ExtractExpirationDate)('0319');

        $I->assertEquals(['month' => '03', 'year' => '19'], $date);
    }

    public function testFiveDigit(UnitTester $I)
    {
        $date = (new ExtractExpirationDate)('32019');

        $I->assertEquals(['month' => '03', 'year' => '19'], $date);
    }

    public function testSixDigit(UnitTester $I)
    {
        $date = (new ExtractExpirationDate)('032019');

        $I->assertEquals(['month' => '03', 'year' => '19'], $date);
    }

    public function testExpirationYearAfter31(UnitTester $I)
    {
        $date = (new ExtractExpirationDate)('03/32');
        $I->assertEquals(['month' => '03', 'year' => '32'], $date);
    }
}
