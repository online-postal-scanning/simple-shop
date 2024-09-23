<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Factory;

use OLPS\SimpleShop\Interactor\InsertInvoiceInterface;
use OLPS\SimpleShop\Interactor\ProcessPayment;
use Omnipay\Common\GatewayInterface;
use Psr\Container\ContainerInterface;

final class ProcessPaymentFactory
{
    public function __invoke(ContainerInterface $container): ProcessPayment
    {
        $gateway = $container->get(GatewayInterface::class);
        $insertInvoice = $container->get(InsertInvoiceInterface::class);

        return new ProcessPayment($gateway, $insertInvoice);
    }
}
