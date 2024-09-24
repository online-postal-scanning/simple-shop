<?php
declare(strict_types=1);

namespace Tests\Unit\OLPS\SimpleShop\Interactor\DBal;

use OLPS\SimpleShop\Interactor\DBal\SQLToBool;
use PHPUnit\Framework\TestCase;

class SQLToBoolTest extends TestCase
{
    public function testInvoke()
    {
        $sqlToBool = new SQLToBool();
        $this->assertTrue($sqlToBool(1));
        $this->assertFalse($sqlToBool(0));
    }
}
