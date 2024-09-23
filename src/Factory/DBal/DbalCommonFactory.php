<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Factory\DBal;

use Doctrine\DBAL\Connection;
use OLPS\SimpleShop\Interactor\DBal\DBalCommon;
use OLPS\SimpleShop\Interactor\DBal\GatherCategoryDataForProduct;
use OLPS\SimpleShop\Interactor\FindInvoiceByIdInterface;
use OLPS\SimpleShop\Interactor\FindCardByIdInterface;
use OLPS\SimpleShop\Interactor\FindCardByLastFourInterface;
use OLPS\SimpleShop\Interactor\FindProductByNameInterface;
use OLPS\SimpleShop\Interactor\InsertCardInterface;
use OLPS\SimpleShop\Interactor\InsertCheckInterface;
use OLPS\SimpleShop\Interactor\InsertInvoiceInterface;
use OLPS\SimpleShop\Interactor\InsertMoneyOrderInterface;
use OLPS\SimpleShop\Interactor\PaymentMethod\ProcessCheck;
use OLPS\SimpleShop\Interactor\PaymentMethod\ProcessMoneyOrder;
use OLPS\SimpleShop\Interactor\SaveInvoiceInterface;
use OLPS\SimpleShop\Interactor\SaveProductInterface;
use OLPS\SimpleShop\Interactor\UpdateInvoiceInterface;
use Psr\Container\ContainerInterface;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

final class DbalCommonFactory implements AbstractFactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ): DBalCommon {
        $connection = $container->get(Connection::class);
        $className = $this->getClassNameFromRequestedName($requestedName);

        return new $className($connection);
    }

    public function canCreate(
        ContainerInterface $container,
        $requestedName
    ) {
        $acceptableInterfaces = [
            FindCardByIdInterface::class,
            FindCardByLastFourInterface::class,
            FindInvoiceByIdInterface::class,
            FindProductByNameInterface::class,
            GatherCategoryDataForProduct::class,
            InsertCardInterface::class,
            InsertCheckInterface::class,
            InsertInvoiceInterface::class,
            InsertMoneyOrderInterface::class,
            SaveInvoiceInterface::class,
            SaveProductInterface::class,
            UpdateInvoiceInterface::class,
        ];

        if (in_array($requestedName, $acceptableInterfaces)) {
            return true;
        }

        foreach ($acceptableInterfaces as $interface) {
            if (is_subclass_of($requestedName, $interface)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if we can create a service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     *
     * @return bool
     */
    public function canCreateServiceWithName(
        ServiceLocatorInterface $serviceLocator,
        $name,
        $requestedName
    ) {
        // TODO: Implement canCreateServiceWithName() method.
    }

    /**
     * Create service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     *
     * @return mixed
     */
    public function createServiceWithName(
        ServiceLocatorInterface $serviceLocator,
        $name,
        $requestedName
    ) {
        // TODO: Implement createServiceWithName() method.
    }

    private function getClassNameFromRequestedName($name): string
    {
        if (class_exists($name)) {
            return $name;
        }

        $parts = explode('\\', $name);
        $class = substr($parts[3], 0, -9);
        $parts[3] = 'DBal';
        $parts[4] = $class;

        return implode('\\', $parts);
    }
}
