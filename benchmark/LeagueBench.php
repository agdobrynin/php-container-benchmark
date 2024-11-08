<?php

declare(strict_types=1);

namespace Benchmark;

require_once dirname(__DIR__) . '/containers/league/vendor/autoload.php';

use League\Container\Container;
use League\Container\ReflectionContainer;
use PhpBench\Attributes\Groups;
use Project\Generated\Service0;
use Project\Generated\Service6;
use Project\Generated\ServiceImplementation;
use Project\Generated\ServiceInterface;

#[Groups(["Runtime"])]
class LeagueBench extends AbstractContainer
{
    public function getContainer(): void
    {
        $container = new Container();
        $container->defaultToShared();
        $container->delegate(new ReflectionContainer(true));
        $container->addShared('some_alias', Service6::class)
            ->addArgument(Service0::class);
        $container->addShared(ServiceInterface::class, ServiceImplementation::class)
            ->addArgument(Service0::class);
        // FYI: League offers no way to provide it with the Services that are wanted for injection if you want autowiring.
        // I guess that makes it extremely flexible, but also terribly slow.
        $services = !empty(getenv('SERVICES')) ? getenv('SERVICES') : 100;

        $this->container = $container;
    }
}
