<?php

namespace CArray;

use Exception;

class CArray
{
    private int $size;
    private array $items;

    /**
     * CArray constructor.
     * @param int $size
     */
    public function __construct(int $size)
    {
        $this->size = $size;
        $this->items = [];
    }

    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $index
     * @param mixed $data
     * @throws Exception
     */
    public function setItem(int $index, mixed $data)
    {
        if ($index < $this->size) {
            $this->items[$index] = $data;
        } else {
            throw new Exception('Index out of bounds.');
        }
    }

    /**
     * @param int $index
     * @return mixed
     * @throws Exception
     */
    public function getItem(int $index): mixed
    {
        if ($index < $this->size) {
            return $this->items[$index] ?? null;
        } else {
            throw new Exception('Segmentation fault (core dumped).');
        }
    }

}
