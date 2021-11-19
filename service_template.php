<?php

/** @var string $name */
/** @var ?int $required */

assert(is_string($name));
assert(is_int($required) || is_null($required));

$requirement = $required !== null ? "private Service$required \$service" : "";

echo "<?php" . PHP_EOL;

?>

namespace Project\Generated;

class <?= $name ?>
{
public function __construct(<?= $requirement ?>)
{
}
}
