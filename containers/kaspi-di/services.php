<?php
declare(strict_types=1);

use function Kaspi\DiContainer\diGet;

return static function (): \Generator {
    yield 'some_alias' => diGet(Project\Generated\Service6::class);

    yield Project\Generated\ServiceInterface::class => diGet(Project\Generated\ServiceImplementation::class);
};
