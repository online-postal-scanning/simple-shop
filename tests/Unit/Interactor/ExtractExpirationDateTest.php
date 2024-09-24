<?php

declare(strict_types=1);

namespace Tests\Unit\OLPS\SimpleShop\Interactor;

use OLPS\SimpleShop\Interactor\ExtractExpirationDate;
use PHPUnit\Framework\TestCase;

class ExtractExpirationDateTest extends TestCase
{
    public function testSeparatingCharacter()
    {
        $extractor = new ExtractExpirationDate();
        $date = $extractor('3-19');

        $this->assertEquals(['month' => '03', 'year' => '19'], $date);
    }

    public function testSeparatingCharacterNoLeadingZero()
    {
        $extractor = new ExtractExpirationDate();
        $date = $extractor('03-19');

        $this->assertEquals(['month' => '03', 'year' => '19'], $date);
    }

    public function testSeparatingCharacterFourDigitYear()
    {
        $extractor = new ExtractExpirationDate();
        $date = $extractor('11/2020');

        $this->assertEquals(['month' => '11', 'year' => '20'], $date);
    }

    public function testThreeDigit()
    {
        $extractor = new ExtractExpirationDate();
        $date = $extractor('319');

        $this->assertEquals(['month' => '03', 'year' => '19'], $date);
    }

    public function testFourDigit()
    {
        $extractor = new ExtractExpirationDate();
        $date = $extractor('0319');

        $this->assertEquals(['month' => '03', 'year' => '19'], $date);
    }

    public function testFiveDigit()
    {
        $extractor = new ExtractExpirationDate();
        $date = $extractor('32019');

        $this->assertEquals(['month' => '03', 'year' => '19'], $date);
    }

    public function testSixDigit()
    {
        $extractor = new ExtractExpirationDate();
        $date = $extractor('032019');

        $this->assertEquals(['month' => '03', 'year' => '19'], $date);
    }

    public function testExpirationYearAfter31()
    {
        $extractor = new ExtractExpirationDate();
        $date = $extractor('03/32');
        $this->assertEquals(['month' => '03', 'year' => '32'], $date);
    }
}
