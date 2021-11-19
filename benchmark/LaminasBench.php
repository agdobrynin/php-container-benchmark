<?php

declare(strict_types=1);

namespace Benchmark;

require_once dirname(__DIR__) . '/containers/laminas/vendor/autoload.php';

use BluePsyduck\LaminasAutoWireFactory\AutoWireFactory;
use Laminas\ServiceManager\ServiceManager;
use PhpBench\Attributes\Groups;
use Project\Generated\Service6;
use Project\Generated\ServiceImplementation;
use Project\Generated\ServiceInterface;

#[Groups(["Container", "ContainerBenchmark"])]
class LaminasBench extends AbstractContainer
{
    public function getContainer(): void
    {
        AutoWireFactory::setCacheFile(dirname(__DIR__) . '/containers/laminas/src/autowire.cache.php');
        $factories = [ServiceImplementation::class => AutoWireFactory::class];
        $services = !empty(getenv('SERVICES')) ? getenv('SERVICES') : 100;

        for ($i = 0; $i < $services; $i++) {
            $factories["Project\Generated\Service$i"] = AutoWireFactory::class;
        }

        $sm = new ServiceManager([
            'factories' => $factories,
            'aliases' => [
                'some_alias' => Service6::class,
                ServiceInterface::class => ServiceImplementation::class
            ],
            'shared_by_default' => true
        ]);

        $this->container = $sm;
    }
}
