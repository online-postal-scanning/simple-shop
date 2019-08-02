<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Factory\DBal;

use Doctrine\DBAL\Connection;
use IamPersistent\SimpleShop\Interactor\DBal\DBalCommon;
use IamPersistent\SimpleShop\Interactor\FindInvoiceByIdInterface;
use IamPersistent\SimpleShop\Interactor\FindCardByIdInterface;
use IamPersistent\SimpleShop\Interactor\FindCardByLastFourInterface;
use IamPersistent\SimpleShop\Interactor\FindProductByNameInterface;
use IamPersistent\SimpleShop\Interactor\InsertCardInterface;
use IamPersistent\SimpleShop\Interactor\InsertCheckInterface;
use IamPersistent\SimpleShop\Interactor\InsertInvoiceInterface;
use IamPersistent\SimpleShop\Interactor\SaveInvoiceInterface;
use IamPersistent\SimpleShop\Interactor\SaveProductInterface;
use IamPersistent\SimpleShop\Interactor\UpdateInvoiceInterface;
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
            InsertCardInterface::class,
            InsertCheckInterface::class,
            InsertInvoiceInterface::class,
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
