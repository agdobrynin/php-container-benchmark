<?php

declare(strict_types=1);

namespace Benchmark;

use PhpBench\Attributes\Groups;

require_once dirname(__DIR__) . '/containers/kaspi-di/vendor/autoload.php';

#[Groups(["Container", "ContainerBenchmark", "KaspiDiCompile", "Compiled", "KaspiDi", "KaspiDiCompiled"])]
class KaspiDiBench extends AbstractContainer
{
    public function getContainer(): void
    {
        $this->container = new \KaspiDi\Container();
    }
}
