<?php

use CHashMap\CHashMap;

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$map = new CHashMap(0);

for ($i = 0; $i < 10000; $i++) {
    $map->put((string)$i, (string)$i);
    print_r($map->get((string)$i));
    echo "<br />";
}

print_r("total size - " . $map->getTotalSize() . "<br />");
print_r("number of elements - ". $map->getUsedSize());
