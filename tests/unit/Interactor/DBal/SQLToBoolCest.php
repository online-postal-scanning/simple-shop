<?php
declare(strict_types=1);

namespace Tests\Unit\Interactor\DBal;

use Iampersistent\SimpleShop\Interactor\Db\SQLToBool;
use UnitTester;

class SQLToBoolCest
{
    public function testInvoke(UnitTester $I)
    {
        $I->assertTrue((new SQLToBool)(1));
        $I->assertFalse((new SQLToBool)(0));
    }
}
