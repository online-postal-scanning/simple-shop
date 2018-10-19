<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Factory;

use IamPersistent\SimpleShop\Interactor\ProcessPayment;
use Omnipay\Common\GatewayInterface;
use Psr\Container\ContainerInterface;

final class ProcessPaymentFactory
{
    public function __invoke(ContainerInterface $container): ProcessPayment
    {
        $gateway = $container->get(GatewayInterface::class);

        return new ProcessPayment($gateway);
    }
}