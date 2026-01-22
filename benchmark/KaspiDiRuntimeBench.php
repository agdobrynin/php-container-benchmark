<?php

declare(strict_types=1);

namespace Benchmark;

use Kaspi\DiContainer\DefinitionsLoader;
use Kaspi\DiContainer\DiContainerBuilder;
use Kaspi\DiContainer\DiContainerConfig;
use PhpBench\Attributes\Groups;

require_once dirname(__DIR__) . '/containers/kaspi-di/vendor/autoload.php';

#[Groups(["Runtime", "KaspiDi"])]
class KaspiDiRuntimeBench extends AbstractContainer
{
    public function getContainer(): void
    {
        $config = new DiContainerConfig(
            useZeroConfigurationDefinition: true,
            useAttribute: false,
            isSingletonServiceDefault: true,
        );

        $this->container = (new DiContainerBuilder($config))
            ->import('Project\\', __DIR__.'/../src')
            ->load(__DIR__.'/../containers/kaspi-di/services.php')
            ->build()
        ;
    }
}
