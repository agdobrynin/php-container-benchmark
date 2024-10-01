<?php

$services = empty(getenv('SERVICES')) ? 100 : getenv('SERVICES');
$max = $services - 1;

for ($i = 0; $i < $services; $i++) {
    $name = "Service$i";

    $required = $i === $max ? null : $i + 1;

    ob_start();
    include "service_template.php";
    file_put_contents(sprintf("%s/src/Generated/%s.php", __DIR__, $name), ob_get_clean());
}

file_put_contents(sprintf("%s/src/Generated/ServiceInterface.php", __DIR__), <<<INTERFACE
<?php

namespace Project\Generated;

interface ServiceInterface{}
INTERFACE
);

file_put_contents(sprintf("%s/src/Generated/ServiceImplementation.php", __DIR__), <<<IMPLEMENTATION
<?php

namespace Project\Generated;

class ServiceImplementation implements ServiceInterface
{
    public function __construct(private Service0 \$service){
    
    }
}
IMPLEMENTATION
);
