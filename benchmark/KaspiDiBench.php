<?php

declare(strict_types=1);

namespace Benchmark;

use Kaspi\DiContainer\DiContainer;
use Kaspi\DiContainer\DiContainerConfig;
use PhpBench\Attributes\Groups;

require_once dirname(__DIR__) . '/containers/kaspi-di/vendor/autoload.php';

#[Groups([
    "Container",
    "ContainerBenchmark",
    "KaspiDi",
    "Runtime",
    "KaspiDiVsPhpDi",
    "Compiled",
])]
class KaspiDiBench extends AbstractContainer
{
    public function getContainer(): void
    {
        $this->container = new DiContainer(
            require __DIR__ . '/../containers/kaspi-di/definitions_loader.php',
            new DiContainerConfig(
                useZeroConfigurationDefinition: false,
                useAttribute: false,
                isSingletonServiceDefault: true,
            )
        );
    }
}
