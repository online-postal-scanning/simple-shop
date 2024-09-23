<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Factory;

use OLPS\SimpleShop\Interactor\AuthorizeCard;
use OLPS\SimpleShop\Interactor\InsertCardInterface;
use Omnipay\Common\GatewayInterface;
use Psr\Container\ContainerInterface;

final class AuthorizeCardFactory
{
    public function __invoke(ContainerInterface $container): AuthorizeCard
    {
        $gateway = $container->get(GatewayInterface::class);
        $insertCard = $container->get(InsertCardInterface::class);

        return new AuthorizeCard($gateway, $insertCard);
    }
}
