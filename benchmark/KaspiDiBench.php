<?php

declare(strict_types=1);

namespace Benchmark;

use Kaspi\DiContainer\DiContainer;
use Kaspi\DiContainer\DiContainerConfig;
use PhpBench\Attributes\Groups;
use Project\Generated\Service6;
use Project\Generated\ServiceImplementation;
use Project\Generated\ServiceInterface;

require_once dirname(__DIR__) . '/containers/kaspi-di/vendor/autoload.php';

#[Groups([
    "Container",
    "ContainerBenchmark",
    "KaspiDi",
    "KaspiDiVsPhpDi",
    "KaspiDiVsYii",
    "KaspiDiVsSpiral"
])]
class KaspiDiBench  extends AbstractContainer
{

    public function getContainer(): void
    {
        $definitions = [
            ServiceImplementation::class => ServiceImplementation::class,
            ServiceInterface::class => ServiceImplementation::class,
            'some_alias' => Service6::class,
        ];
        $services = !empty(getenv('SERVICES')) ? getenv('SERVICES') : 100;
        for ($i = 0; $i < $services; $i++) {
            $definitions["Project\Generated\Service$i"] = "Project\Generated\Service$i";
        }

        $config = new DiContainerConfig(
            useAutowire: true,
            useZeroConfigurationDefinition: false,
            useAttribute: false,
            isSingletonServiceDefault: true,
        );
        $this->container = new DiContainer($definitions, $config);
    }
}
