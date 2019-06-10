<?php

namespace IOC\Holders;

class InstancesHolder implements InstancesHolderInterface
{
    private $instances = [];

    public function __get(string $key)
    {
        if (!array_key_exists($key, $this->instances)) {
            throw new \Exception("$key object does not exist in the container", 1);
        }
        return $this->instances[$key];
    }

    public function __set(string $key, $value): void
    {
        if (array_key_exists($key, $this->instances)) {
            throw new \Exception("$key already exists in the container", 1);
        }
        $this->instances[$key] = $value;
    }

    public function __isset(string $key): boolean
    {
        return (isset($this->instances[$key])) ? true : false;
    }
}