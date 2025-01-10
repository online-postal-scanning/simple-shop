<?php

namespace Tests\Integration;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDO\MySQL\Driver;
use PDO;
use PHPUnit\Framework\TestCase;

abstract class IntegrationTestCase extends TestCase
{
    protected static Connection $connection;
    protected static MigrationRunner $migrationRunner;
    protected static ?PDO $pdo;

    public static function setUpBeforeClass(): void
    {
        $params = [
            'host' => $_ENV['TEST_DB_HOST'],
            'port' => $_ENV['TEST_DB_PORT'],
            'user' => $_ENV['TEST_DB_USER'],
            'password' => $_ENV['TEST_DB_PASS'],
            'dbname' => $_ENV['TEST_DB_NAME'],
            'driver' => 'mysql',
        ];
        
        $driver = new Driver();
        self::$connection = new Connection($params, $driver);
        // Initialize MigrationRunner
        self::$migrationRunner = new MigrationRunner();

        // Run migrations to set up the database schema
        self::$migrationRunner->migrate('testing');

        parent::setUpBeforeClass();
    }
    
    public static function tearDownAfterClass(): void
    {
        // Rollback all migrations
        self::$migrationRunner->rollback('testing', '0');

        self::$pdo = null;
    }

    protected function generateUniqueIdentifier(int $length = 40): string
    {
        return bin2hex(random_bytes($length));
    }

    protected function seedDatabase(): void
    {
        // order matters

    }

    protected function setUp(): void
    {
        // Optionally, you can reset the database before each test
        // self::$migrationRunner->reset('testing');
    }

    protected function tearDown(): void
    {
        // Clean up test data after each test if needed
        // This depends on your specific needs. You might want to truncate tables instead of dropping them.
        // For example:
        // self::$pdo->exec("TRUNCATE TABLE users");
    }

    protected static function formatValues(array $values): string
    {
        return implode(', ', array_map(function ($value) {
            return "'" . $value . "'";
        }, $values));
    }
}
