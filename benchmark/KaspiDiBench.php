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
        $definitions = [
            \Project\Generated\ServiceInterface::class => \Project\Generated\ServiceImplementation::class,
            'some_alias' => \Project\Generated\Service6::class,
        ];
        $services = !empty(getenv('SERVICES')) ? getenv('SERVICES') : 100;
        for ($i = 0; $i < $services; $i++) {
            $definitions["Project\Generated\Service$i"];
        }

        $this->container = (new DiContainerFactory())
            ->make($definitions);
    }
}
