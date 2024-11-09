<?php

declare(strict_types=1);

namespace Benchmark;

require_once dirname(__DIR__) . '/containers/php-di/vendor/autoload.php';

use CompiledContainer;
use PhpBench\Attributes\Groups;

#[Groups(["Container", "ContainerBenchmark", "Compiled"])]
class PhpDiBench extends AbstractContainer
{
    public function getContainer(): void
    {
        $this->container = new CompiledContainer();
    }
}
