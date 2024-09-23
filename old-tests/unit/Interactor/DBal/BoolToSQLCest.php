<?php
declare(strict_types=1);

namespace Tests\Unit\Interactor\DBal;

use IamPersistent\SimpleShop\Interactor\DBal\BoolToSQL;
use UnitTester;

class BoolToSQLCest
{
    public function testInvoke(UnitTester $I)
    {
        $I->assertIsInt(1, (new BoolToSQL)(true));
        $I->assertIsInt(0, (new BoolToSQL)(false));
    }
}
