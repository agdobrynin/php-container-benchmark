<?php

declare(strict_types=1);

namespace Benchmark;

require_once dirname(__DIR__) . '/containers/zen/vendor/autoload.php';

use PhpBench\Attributes\Groups;
use Zen\Container;

#[Groups(["Container", "ContainerBenchmark", "Compiled", "Match"])]
class ZenBench extends AbstractContainer
{
    public function getContainer(): void
    {
        $this->container = new Container();
    }
}
