<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Kaspi\DiContainer\DefinitionsLoader;

return (new DefinitionsLoader(KASPI_DI_CACHE_FILE))
    ->import(
        namespace: 'Project\\',
        src: __DIR__ . '/../../src/',
        useAttribute: false,
    )
    ->load(__DIR__ . '/services.php')
    ->definitions()
;
