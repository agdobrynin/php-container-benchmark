<?php

declare(strict_types=1);

namespace Benchmark;

require_once dirname(__DIR__) . '/containers/php-di/vendor/autoload.php';

use PhpBench\Attributes\Groups;
use Project\Generated\Service6;
use Project\Generated\ServiceImplementation;
use Project\Generated\ServiceInterface;
use DI\Container;

#[Groups(["Runtime"])]
class PhpDiRuntimeBench extends AbstractContainer
{
    public function getContainer(): void
    {
        $dependencies = [];
        $services = !empty(getenv('SERVICES')) ? getenv('SERVICES') : 100;

        for ($i = 0; $i < $services; $i++) {
            $dependencies["Project\Generated\Service$i"] = "Project\Generated\Service$i";
        }

        $dependencies[ServiceInterface::class] = ServiceImplementation::class;
        $dependencies[ServiceImplementation::class] = ServiceImplementation::class;
        $dependencies['some_alias'] = Service6::class;

        $this->container = (new \DI\ContainerBuilder())
            ->addDefinitions($dependencies)
            ->useAnnotations(false)
            ->build();
    }
}
