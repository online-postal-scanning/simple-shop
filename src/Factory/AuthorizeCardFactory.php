<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Factory;

use IamPersistent\SimpleShop\Interactor\AuthorizeCard;
use IamPersistent\SimpleShop\Interactor\InsertCardInterface;
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