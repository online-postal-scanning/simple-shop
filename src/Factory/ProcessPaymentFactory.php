<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Factory;

use IamPersistent\SimpleShop\Interactor\ProcessPayment;

final class ProcessPaymentFactory
{
    public function __invoke(ContainerInterface $container): ProcessPayment
    {

        return new ProcessPayment($gateway);
    }
}