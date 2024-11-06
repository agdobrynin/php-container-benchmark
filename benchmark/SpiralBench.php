<?php

declare(strict_types=1);

namespace Benchmark;

require_once dirname(__DIR__) . '/containers/spiral/vendor/autoload.php';

use PhpBench\Attributes\Groups;
use Project\Generated\Service6;
use Project\Generated\ServiceImplementation;
use Project\Generated\ServiceInterface;
use Spiral\Core\Container;

#[Groups(["KaspiDiVsSpiral"])]
class SpiralBench extends AbstractContainer
{
    public function getContainer(): void
    {
        $services = !empty(getenv('SERVICES')) ? getenv('SERVICES') : 100;

        $container = new Container();

        for ($i = 0; $i < $services; $i++) {
            $container->bindSingleton("Project\Generated\Service$i", "Project\Generated\Service$i");
        }

        $container->bindSingleton(ServiceImplementation::class, ServiceImplementation::class);
        $container->bindSingleton(ServiceInterface::class,ServiceImplementation::class);
        $container->bind('some_alias', Service6::class);

        $this->container = $container;
    }
}
