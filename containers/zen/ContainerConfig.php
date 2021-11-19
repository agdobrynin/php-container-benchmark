<?php

namespace Zen;

use Project\Generated\Service6;
use Project\Generated\ServiceImplementation;
use Project\Generated\ServiceInterface;
use WoohooLabs\Zen\Config\AbstractContainerConfig;
use WoohooLabs\Zen\Config\EntryPoint\ClassEntryPoint;
use WoohooLabs\Zen\Config\EntryPoint\Psr4NamespaceEntryPoint;

class ContainerConfig extends AbstractContainerConfig
{
    protected function getEntryPoints(): array
    {
        return [
            new ClassEntryPoint(ServiceInterface::class),
            new ClassEntryPoint(ServiceImplementation::class),
            new ClassEntryPoint('some_alias'),
            new ClassEntryPoint(Service6::class),
            new Psr4NamespaceEntryPoint('Project\Generated'),
        ];
    }

    protected function getDefinitionHints(): array
    {
        return [
            'some_alias' => Service6::class,
            ServiceInterface::class => ServiceImplementation::class
        ];
    }

    protected function getWildcardHints(): array
    {
        return [];
    }
}
