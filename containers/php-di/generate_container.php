<?php

use DI\ContainerBuilder;
use Project\Generated\Service6;
use Project\Generated\ServiceImplementation;
use Project\Generated\ServiceInterface;
use function DI\autowire;
use function DI\get;

require_once __DIR__ . '/vendor/autoload.php';
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

$builder = new ContainerBuilder();
$builder->useAutowiring(true);
$builder->useAttributes(false);
$builder->enableCompilation(__DIR__ . '/src');
$builder->writeProxiesToFile(true, __DIR__ . '/src/Proxies');

$definitions = [
    'some_alias' => get(Service6::class),
    ServiceInterface::class => get(ServiceImplementation::class)
];

$services = !empty(getenv('SERVICES')) ? getenv('SERVICES') : 100;
for ($i = 0; $i < $services; $i++) {
    $definitions["Project\Generated\Service$i"] = autowire();
}

$builder->addDefinitions($definitions);
$builder->build();
