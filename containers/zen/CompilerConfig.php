<?php

namespace Zen;

use WoohooLabs\Zen\Config\AbstractCompilerConfig;

class CompilerConfig extends AbstractCompilerConfig
{
    public function getContainerNamespace(): string
    {
        return 'Zen';
    }

    public function getContainerClassName(): string
    {
        return 'Container';
    }

    public function useConstructorInjection(): bool
    {
        return true;
    }

    public function usePropertyInjection(): bool
    {
        return false;
    }

    public function getContainerConfigs(): array
    {
        return [
            new ContainerConfig()
        ];
    }
}
