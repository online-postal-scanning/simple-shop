<?php
declare(strict_types=1);

namespace Tests\Unit\OLPS\SimpleShop\Interactor\DBal;

use OLPS\SimpleShop\Interactor\DBal\BoolToSQL;
use PHPUnit\Framework\TestCase;

class BoolToSQLTest extends TestCase
{
    public function testInvoke()
    {
        $boolToSQL = new BoolToSQL();

        $this->assertSame(1, $boolToSQL(true));
        $this->assertSame(0, $boolToSQL(false));
    }
}
