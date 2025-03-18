<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Kaspi\DiContainer\DefinitionsLoader;
use Project\Generated\Service6;
use Project\Generated\ServiceImplementation;
use Project\Generated\ServiceInterface;
use function Kaspi\DiContainer\diAutowire;
use function Kaspi\DiContainer\diGet;

return (new DefinitionsLoader(KASPI_DI_CACHE_FILE))
    ->import(
        namespace: 'Project\\',
        src: __DIR__ . '/../../src/',
        useAttribute: false,
    )
    ->addDefinitions(
        false,
        [
            'some_alias' => diGet(Service6::class),
            ServiceInterface::class => diAutowire(ServiceImplementation::class),
        ]
    )
    ->definitions()
;
