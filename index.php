<?php

use CHashMap\CHashMap;

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

echo "CArray - object to replicate the behaviour of a statically allocated array at least on a basic level, will replace all strings with CArrays in the future";
echo "<br />";

echo "CHashMap - an object that shows how a dynamic hash map might be implemented on an architecture which only allows for statically allocated arrays. " .
    "Contains the maps current size, amount of space used and CArray where each item is either NULL or CHashMapElement. " .
    "If the number of elements would overflow the size of map, it gets rehashed to (original size + 1) * 2, for the purpose of demonstration I found this compromise between rehashing too often and consuming too much memory fairly sound, though it *may* cause issues for very large arrays. ";
echo "<br />";

echo "CHashMapElement - element of map, contains its name as string and mixed value.";
echo "<br />";
echo "<br />";

$map = new CHashMap(0);

for ($i = 0; $i < 10000; $i++) {
    $map->put((string)$i, (string)$i);
    print_r($map->get((string)$i));
    echo "<br />";
}

print_r("total size - " . $map->getTotalSize() . "<br />");
print_r("number of elements - ". $map->getUsedSize());
