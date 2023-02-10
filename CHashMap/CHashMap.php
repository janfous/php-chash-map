<?php

namespace CHashMap;

use CArray\CArray;
use Exception;

class CHashMap
{

    const HMAP_FULL = 1;

    private int $totalSize;
    private int $usedSize;
    private CArray $elements;

    /**
     * CHashMap constructor.
     * @param int $totalSize
     */
    public function __construct(int $totalSize)
    {
        $this->usedSize = 0;
        $this->totalSize = $totalSize;
        $this->elements = new CArray($totalSize);
    }

    /**
     * @return int
     */
    public function getTotalSize(): int
    {
        return $this->totalSize;
    }

    /**
     * @return int
     */
    public function getUsedSize(): int
    {
        return $this->usedSize;
    }

    /**
     * @param string $name
     * @return int
     *
     * hash string using MurmurHash one-at-a-time approach, return (result % map->totalSize) to get an index inside the map
     */
    private function hashName(string $name): int
    {
        $hash = 0xcab324d5;

        for ($i = 0; $i < strlen($name); $i++) {
            $hash ^= (int)$name[$i];
            $hash *= 0x4fd024fc;
            $hash ^= $hash >> 13;
        }

        return ($hash % $this->totalSize);
    }

    /**
     * @param string $name
     * @return int
     * @throws Exception
     *
     * attempt to find the next empty spot for name in map, return HMAP_FULL if map is full, otherwise return index
     */
    private function getEmpty(string $name): int
    {
        if ($this->totalSize == $this->usedSize) {
            return self::HMAP_FULL;
        }

        $current = $this->hashName($name);

        for ($i = 0; $i < $this->totalSize; $i++) {
            $currentElement = $this->elements->getItem($current);
            if (!$currentElement || $currentElement->getName() == $name) {
                return $current;
            }

            $current = ($current + 1) % $this->totalSize;
        }

        return self::HMAP_FULL;
    }

    /**
     * @throws Exception
     *
     * double the size of map
     */
    private function rehash(): void
    {
        $oldSize = $this->totalSize;

        $this->totalSize += 1;
        $this->totalSize *= 2;
        $this->usedSize = 0;

        $temporaryMap = new CArray($this->totalSize);

        $current = $this->elements;
        $this->elements = $temporaryMap;

        for ($i = 0; $i < $oldSize; $i++) {
            if ($current->getItem($i)) {
                $this->put($current->getItem($i)->getName(), $current->getItem($i)->getValue());
            }
        }
    }

    /**
     * @param string $name
     * @param string $value
     * @throws Exception
     *
     * attempt to add new item to map, rehash if map full
     */
    public function put(string $name, string $value): void
    {
        $index = $this->getEmpty($name);

        while ($index == self::HMAP_FULL) {
            $this->rehash();
            $index = $this->getEmpty($name);
        }

        $element = new CHashMapElement($name, $value);
        $this->elements->setItem($index, $element);
        $this->usedSize += 1;
    }

    /**
     * @param string $name
     * @return mixed
     * @throws Exception
     *
     * attempt to get item from map, NULL if not found
     */
    public function get(string $name): mixed
    {
        $current = $this->hashName($name);

        for ($i = 0; $i < $this->totalSize; $i++) {

            $currentElement = $this->elements->getItem($current);

            if ($currentElement && $currentElement->getName() == $name) {
                return $currentElement->getValue();
            }

            $current = ($current + 1) % $this->totalSize;
        }

        return null;
    }

    /**
     * @param string $name
     * @throws Exception
     *
     * attempt to set value of item in map to null
     *
     * TODO 1: what if index does not exist in large map? consider edit to reduce pointless iteration over the rest of the map
     * TODO 2: similar to $this->get --- consider refactor
     */
    public function delete(string $name)
    {
        $current = $this->hashName($name);

        for ($i = 0; $i < $this->totalSize; $i++) {

            $currentElement = $this->elements->getItem($current);

            if ($currentElement && $currentElement->getName() == $name) {
                $this->elements->setItem($current, null);
            }

            $current = ($current + 1) % $this->totalSize;
        }
    }

}
