<?php
declare(strict_types=1);

namespace Tests\Functional\Interactor\DBal;

use DateTime;
use FunctionalTester;
use IamPersistent\SimpleShop\Entity\Check;
use IamPersistent\SimpleShop\Interactor\DBal\InsertCheck;

class InsertCheckCest
{
    /** @var \Doctrine\DBAL\Connection */
    private $connection;
    /** @var \IamPersistent\SimpleShop\Interactor\DBal\InsertCheck */
    private $insertCheck;

    public function _after(FunctionalTester $I)
    {
        $I->dropDatabase();
    }

    public function _before(FunctionalTester $I)
    {
        $this->connection = $I->getDBalConnection();
        $I->setUpDatabase();
        $this->insertCheck = new InsertCheck($this->connection);
    }

    public function testInsert(FunctionalTester $I)
    {
        $check = (new Check())
            ->setCheckNumber('1024')
            ->setDate(new DateTime('2018-10-01'));
        $this->insertCheck->insert($check);
        $checkData = $this->connection->fetchAll('SELECT * FROM checks');
        $I->assertEquals($this->expectedCheckData(), $checkData);
    }

    public function testInsertNoDate(FunctionalTester $I)
    {
        $check = (new Check())
            ->setCheckNumber('1024');
        $this->insertCheck->insert($check);
        $checkData = $this->connection->fetchAll('SELECT * FROM checks');
        $I->assertEquals($this->expectedCheckWithNoDateData(), $checkData);
    }

    private function expectedCheckData(): array
    {
        return [
            [
                'check_number' => '1024',
                'date'         => '2018-10-01',
                'id'           => '1',
            ],
        ];
    }

    private function expectedCheckWithNoDateData(): array
    {
        return [
            [
                'check_number' => '1024',
                'date'         => null,
                'id'           => '1',
            ],
        ];
    }
}
