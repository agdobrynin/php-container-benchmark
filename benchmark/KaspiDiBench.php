<?php

declare(strict_types=1);

namespace Benchmark;

use Kaspi\DiContainer\DiContainerFactory;
use PhpBench\Attributes\Groups;
use Project\Generated\Service6;
use Project\Generated\ServiceImplementation;
use Project\Generated\ServiceInterface;

require_once dirname(__DIR__) . '/containers/kaspi-di/vendor/autoload.php';

#[Groups(["Container", "ContainerBenchmark", "Match"])]
class KaspiDiBench  extends AbstractContainer
{

    public function getContainer(): void
    {
        $this->container = (new DiContainerFactory())
            ->make([
                \Project\Generated\ServiceInterface::class => \Project\Generated\ServiceImplementation::class,
                'some_alias' => \Project\Generated\Service6::class,
            ]);
    }
}
