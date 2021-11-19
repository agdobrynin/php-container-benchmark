<?php

use Riaf\Configuration\BaseConfiguration;
use Riaf\Configuration\ContainerCompilerConfiguration;

class Config extends BaseConfiguration implements ContainerCompilerConfiguration
{
    public function getContainerNamespace(): string
    {
        return "Riaf";
    }

    public function getContainerFilepath(): string
    {
        return "/src/Container.php";
    }

    public function getAdditionalServices(): array
    {
        return [
            \Project\Generated\Service6::class => \Riaf\Configuration\ServiceDefinition::create(\Project\Generated\Service6::class)
            ->setAliases('some_alias')
        ];
    }
}
