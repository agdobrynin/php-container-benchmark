<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Kaspi\DiContainer\DiContainerBuilder;
use Kaspi\DiContainer\DiContainerConfig;

(new DiContainerBuilder(
    new DiContainerConfig(
        useZeroConfigurationDefinition: false,
        useAttribute: false,
        isSingletonServiceDefault: true,
    )
))
    ->import('Project\\', __DIR__.'/../../src')
    ->load(__DIR__.'/services.php')
    ->compileToFile(__DIR__.'/src', 'KaspiDi\\Container')
    ->build()
;
print sprintf('DiContainer Compiled to: %s'.PHP_EOL, __DIR__.'/src/Container.php');
