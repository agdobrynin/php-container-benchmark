<?php

declare(strict_types=1);

namespace Benchmark;

use Generator;
use PhpBench\Attributes\BeforeMethods;
use PhpBench\Attributes\Groups;
use PhpBench\Attributes\Iterations;
use PhpBench\Attributes\ParamProviders;
use PhpBench\Attributes\Revs;
use Project\Generated\Service1;
use Project\Generated\Service6;
use Project\Generated\ServiceImplementation;
use Project\Generated\ServiceInterface;

#[Revs(2)]
#[Iterations(100)]
#[Groups(["Container"])]
abstract class AbstractContainer
{
    protected mixed $container;
    private int $max;

    public function __construct()
    {
        $this->max = (!empty(getenv("SERVICES")) ? getenv("SERVICES") : 100) - 1;
    }

    public function provideServiceNamesHas(): Generator
    {
        $generator = $this->provideServiceNames();

        foreach ($generator as $key => $value) {
            yield str_replace("GET", "HAS", $key) => $value;
        }
    }

    public function provideServiceNames(): Generator
    {
        yield "GET Best Case" => ["services" => Service1::class];
        yield "GET Worst Case Service{$this->max}" => ["services" => "Project\Generated\Service{$this->max}"];
        yield "GET Implementation " => ["services" => ServiceImplementation::class];
        yield "GET Interface" => ["services" => ServiceInterface::class];
        yield "GET Alias" => ["services" => "some_alias"];
        yield "GET Service For Alias" => ["services" => Service6::class];
//        yield 'GET Alias Then Service' => ['services' => ['some_alias', Service6::class]];
//        yield 'GET Interface Then Implementation' => ['services' => [ServiceInterface::class, ServiceImplementation::class]];
//        yield 'GET Services Then Max' => ['services' => [Service1::class, Service3::class, Service4::class, Service7::class, "Project\Generated\Service{$this->max}"]];
    }

    abstract public function getContainer(): void;

    #[BeforeMethods("getContainer")]
    #[ParamProviders("provideServiceNames")]
    public function benchGetter(array $params): void
    {
        $instance = $this->container->get($params["services"]);
        assert($instance !== null);
    }

    #[Revs(1000)]
    #[BeforeMethods("getContainer")]
    #[ParamProviders("provideServiceNamesHas")]
    public function benchHasser(array $params): void
    {
        $instance = $this->container->has($params["services"]);
        assert($instance !== false);
    }
}
