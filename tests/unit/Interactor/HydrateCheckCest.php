<?php
declare(strict_types=1);

namespace Tests\Unit\Interactor;

use DateTime;
use IamPersistent\SimpleShop\Entity\Check;
use IamPersistent\SimpleShop\Interactor\DBal\HydrateCheck;
use UnitTester;

class HydrateCheckCest
{
    public function test__invoke(UnitTester $I)
    {
        $checkData = [
            'check_number' => '2048',
            'date'         => '2019-04-20',
            'id'           => 42,
        ];
        $check = (new HydrateCheck())($checkData);
        $I->assertEquals($this->expectedCheck(), $check);
    }

    private function expectedCheck(): Check
    {
        return (new Check())
            ->setCheckNumber('2048')
            ->setDate(new DateTime('2019-04-20'))
            ->setId(42);
    }
}
