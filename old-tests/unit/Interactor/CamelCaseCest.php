<?php
declare(strict_types=1);

namespace Tests\Unit\Interactor;

use UnitTester;
use IamPersistent\SimpleShop\Interactor\CamelCase;

class CamelCaseCest
{
    public function testInvoke(UnitTester $I)
    {
        $I->assertSame('single', (new CamelCase)('single'));
        $I->assertSame('capitalized', (new CamelCase)('Capitalized'));
        $I->assertSame('multipleWords', (new CamelCase)('Multiple_words'));
    }
}
