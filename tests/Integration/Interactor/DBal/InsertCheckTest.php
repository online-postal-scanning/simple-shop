<?php
declare(strict_types=1);

namespace Tests\Integration\Interactor\DBal;

use DateTime;
use OLPS\SimpleShop\Entity\Check;
use OLPS\SimpleShop\Interactor\DBal\InsertCheck;
use Tests\Integration\IntegrationTestCase;

class InsertCheckTest extends IntegrationTestCase
{
    private InsertCheck $insertCheck;

    protected function setUp(): void
    {
        parent::setUp();

        $this->insertCheck = new InsertCheck(self::$connection);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        self::$connection->executeStatement('TRUNCATE TABLE checks');
    }

    public function testInsert(): void
    {
        $check = (new Check())
            ->setCheckNumber('1024')
            ->setDate(new DateTime('2018-10-01'));

        $this->insertCheck->insert($check);
        
        $checkData = self::$connection->fetchAllAssociative('SELECT * FROM checks');
        $this->assertEquals($this->expectedCheckData(), $checkData);
    }

    public function testInsertNoDate(): void
    {
        $check = (new Check())
            ->setCheckNumber('1024');

        $this->insertCheck->insert($check);
        
        $checkData = self::$connection->fetchAllAssociative('SELECT * FROM checks');
        $this->assertEquals($this->expectedCheckWithNoDateData(), $checkData);
    }

    private function expectedCheckData(): array
    {
        return [
            [
                'check_number' => '1024',
                'date'         => '2018-10-01',
                'id'           => 1,
            ],
        ];
    }

    private function expectedCheckWithNoDateData(): array
    {
        return [
            [
                'check_number' => '1024',
                'date'         => null,
                'id'           => 1,
            ],
        ];
    }
}
