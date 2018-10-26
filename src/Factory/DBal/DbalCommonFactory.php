<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Factory\DBal;

use Doctrine\DBAL\Connection;
use IamPersistent\SimpleShop\Interactor\DBal\DBalCommon;
use IamPersistent\SimpleShop\Interactor\FetchInvoiceInterface;
use IamPersistent\SimpleShop\Interactor\FindCardByIdInterface;
use IamPersistent\SimpleShop\Interactor\InsertCardInterface;
use IamPersistent\SimpleShop\Interactor\InsertInvoiceInterface;
use IamPersistent\SimpleShop\Interactor\SaveInvoiceInterface;
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
        $className = $this->getClassNameFromInterface($requestedName);

        return new $className($connection);
    }

    public function canCreate(
        ContainerInterface $container,
        $requestedName
    ) {
        $acceptableInterfaces = [
            FetchInvoiceInterface::class,
            FindCardByIdInterface::class,
            InsertCardInterface::class,
            InsertInvoiceInterface::class,
            SaveInvoiceInterface::class,
            UpdateInvoiceInterface::class,
        ];

        return in_array($requestedName, $acceptableInterfaces);
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

    private function getClassNameFromInterface($interface): string
    {
        $parts = explode('\\', $interface);
        $class = substr($parts[3], 0, -9);
        $parts[3] = 'DBal';
        $parts[4] = $class;

        return implode('\\', $parts);
    }
}
