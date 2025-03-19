<?php
declare(strict_types=1);

/** @var \Generator $definitions */
$definitions = require __DIR__ . '/definitions_loader.php';

while ($definitions->valid()) {
    $definitions->next();
}
