<?php
declare(strict_types=1);

namespace Tests\Unit\Interactor;

use UnitTester;
use IamPersistent\SimpleShop\Interactor\PascalCase;

class PascalCaseCest
{
    public function testInvoke(UnitTester $I)
    {
        $I->assertSame('Single', (new PascalCase)('single'));
        $I->assertSame('Capitalized', (new PascalCase)('Capitalized'));
        $I->assertSame('MultipleWords', (new PascalCase)('Multiple_words'));
        $I->assertSame('SpacedWords', (new PascalCase)('Spaced Words'));
    }
}
