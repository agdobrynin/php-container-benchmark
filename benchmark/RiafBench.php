<?php

declare(strict_types=1);

namespace Benchmark;

require_once dirname(__DIR__) . '/containers/riaf/vendor/autoload.php';

use PhpBench\Attributes\Groups;
use Riaf\Container;

#[Groups(["Container", "ContainerBenchmark", "Compiled", "Match"])]
class RiafBench extends AbstractContainer
{
    public function getContainer(): void
    {
        $this->container = new Container();
    }
}
