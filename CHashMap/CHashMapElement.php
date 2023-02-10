<?php

namespace CHashMap;

class CHashMapElement
{

    private string $name; //TODO replace string with CArray
    private mixed $value;

    /**
     * CHashMapElement constructor.
     * @param string $name
     * @param mixed $value
     */
    public function __construct(string $name, mixed $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return CHashMapElement
     */
    public function setName(string $name): CHashMapElement
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return CHashMapElement
     */
    public function setValue(mixed $value): CHashMapElement
    {
        $this->value = $value;
        return $this;
    }

}
