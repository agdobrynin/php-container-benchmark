<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

$builder = new ContainerBuilder();
$instanceOf = [];
$configurator = new ContainerConfigurator(
    $builder,
    new PhpFileLoader($builder, new FileLocator(__DIR__)),
    $instanceOf,
    __DIR__,
    __FILE__
);

// Apparently Symfony does only auto-alias when the Interface is in the same file as the implementation
// Which is nuts, but eh https://symfony.com/doc/current/service_container/autowiring.html#working-with-interfaces
$configurator->services()
    ->defaults()
    ->autowire()
    ->public()
    ->load('Project\\', '../../src/*')->share()
    ->alias(\Project\Generated\ServiceInterface::class, \Project\Generated\ServiceImplementation::class)->public()
    ->alias('some_alias', \Project\Generated\Service6::class)->public()
;
$builder->compile();
$dumper = new PhpDumper($builder);
// Can't actually call it Container so SymfonyContainer it is I guess
file_put_contents(__DIR__ . '/src/SymfonyContainer.php', $dumper->dump(['class' => 'SymfonyContainer', 'namespace' => 'Symfony']));

