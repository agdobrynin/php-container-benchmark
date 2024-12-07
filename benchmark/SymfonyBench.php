<?php

declare(strict_types=1);

namespace Benchmark;

require_once dirname(__DIR__) . '/containers/symfony/vendor/autoload.php';

use PhpBench\Attributes\Groups;
use Symfony\SymfonyContainer;

#[Groups(["Container", "ContainerBenchmark", "Compiled", "Symfony"])]
class SymfonyBench extends AbstractContainer
{
    public function getContainer(): void
    {
        $this->container = new SymfonyContainer();
    }
}
