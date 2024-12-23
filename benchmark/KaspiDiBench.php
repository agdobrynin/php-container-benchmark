<?php

declare(strict_types=1);

namespace Benchmark;

use Kaspi\DiContainer\DiContainer;
use Kaspi\DiContainer\DiContainerConfig;
use PhpBench\Attributes\Groups;
use function Kaspi\DiContainer\diAutowire;
use Project\Generated\ServiceInterface;
use Project\Generated\ServiceImplementation;
use Project\Generated\Service6;
use function Kaspi\DiContainer\diGet;

require_once dirname(__DIR__) . '/containers/kaspi-di/vendor/autoload.php';

#[Groups([
    "Container",
    "ContainerBenchmark",
    "KaspiDi",
    "Runtime",
    "KaspiDiVsPhpDi",
    "Compiled",
])]
class KaspiDiBench  extends AbstractContainer
{

    public function getContainer(): void
    {
        $services = !empty(getenv('SERVICES')) ? getenv('SERVICES') : 100;

        $definitions = static function () use ($services): \Generator {
            for ($i = 0; $i < $services; $i++) {
                yield diAutowire("Project\\Generated\\Service$i");
            }
            yield diAutowire(ServiceImplementation::class);
            yield 'some_alias' => diGet(Service6::class);
            yield ServiceInterface::class => diGet(ServiceImplementation::class);
        };

        $config = new DiContainerConfig(
            useZeroConfigurationDefinition: false,
            useAttribute: false,
            isSingletonServiceDefault: true,
        );
        $this->container = new DiContainer($definitions(), $config);
    }
}
