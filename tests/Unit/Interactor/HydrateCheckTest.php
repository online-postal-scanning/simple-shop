<?php
declare(strict_types=1);

namespace Tests\Unit\OLPS\SimpleShop\Interactor;

use DateTime;
use OLPS\SimpleShop\Entity\Check;
use OLPS\SimpleShop\Interactor\DBal\HydrateCheck;
use PHPUnit\Framework\TestCase;

class HydrateCheckTest extends TestCase
{
    public function testInvoke()
    {
        $checkData = [
            'check_number' => '2048',
            'date'         => '2019-04-20',
            'id'           => 42,
        ];
        $hydrateCheck = new HydrateCheck();
        $check = $hydrateCheck($checkData);
        $this->assertEquals($this->expectedCheck(), $check);
    }

    private function expectedCheck(): Check
    {
        return (new Check())
            ->setCheckNumber('2048')
            ->setDate(new DateTime('2019-04-20'))
            ->setId(42);
    }
}
