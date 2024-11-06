<?php

declare(strict_types=1);

namespace Benchmark;

require_once dirname(__DIR__) . '/containers/yii/vendor/autoload.php';

use PhpBench\Attributes\Groups;
use Project\Generated\Service6;
use Project\Generated\ServiceImplementation;
use Project\Generated\ServiceInterface;
use Yiisoft\Di\Container;
use Yiisoft\Di\ContainerConfig;

#[Groups(["KaspiDiVsYii"])]
class YiiBench extends AbstractContainer
{
    public function getContainer(): void
    {
        // TODO: YII is currently only available as a dev-master dependency?!
        $services = !empty(getenv('SERVICES')) ? getenv('SERVICES') : 100;
        $factories = [];

        for ($i = 0; $i < $services; $i++) {
            $factories["Project\Generated\Service$i"] = "Project\Generated\Service$i";
        }

        $factories[ServiceInterface::class] = ServiceImplementation::class;
        $factories[ServiceImplementation::class] = ServiceImplementation::class;
        $factories['some_alias'] = Service6::class;

        $config = ContainerConfig::create()
            ->withDefinitions($factories);

        $this->container = new Container($config);
    }
}
