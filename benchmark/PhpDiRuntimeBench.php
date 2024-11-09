<?php

declare(strict_types=1);

namespace Benchmark;

require_once dirname(__DIR__) . '/containers/php-di/vendor/autoload.php';

use PhpBench\Attributes\Groups;
use Project\Generated\Service6;
use Project\Generated\ServiceImplementation;
use Project\Generated\ServiceInterface;

#[Groups(["Runtime", "PhpDiRuntime", "KaspiDiVsPhpDi"])]
class PhpDiRuntimeBench extends AbstractContainer
{
    public function getContainer(): void
    {
        $dependencies = [];
        $services = !empty(getenv('SERVICES')) ? getenv('SERVICES') : 100;

        $container = (new \DI\Container());

        for ($i = 0; $i < $services; $i++) {
            $container->set("Project\Generated\Service$i", \DI\autowire());
        }

        $container->set(ServiceImplementation::class, \DI\autowire());
        $container->set(ServiceInterface::class, \DI\get(ServiceImplementation::class));
        $container->set('some_alias', \DI\get(Service6::class));


        $this->container = $container;
    }
}
