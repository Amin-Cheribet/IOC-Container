<?php

namespace IOC\Holders;

class InstancesHolder implements InstancesHolderInterface
{
    private array $instances = [];

    public function __get(string $key): Object
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

    public function __isset(string $key): bool
    {
        return (isset($this->instances[$key])) ? true : false;
    }

    public function __unset(string $key): void
    {
        if (!array_key_exists($key, $this->instances)) {
            throw new \Exception("$key can't be unset because it doesn't exist", 1);
        }
        unset($this->instances[$key]);
    }
}
