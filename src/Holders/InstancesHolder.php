<?php

namespace IOC\Holders;

class InstancesHolder implements InstancesHolderInterface
{
    private $interfaces = [];

    public function __get(string $key)
    {
        if (!array_key_exists($key, $this->interfaces)) {
            throw new \Exception("$key object does not exist in the container", 1);
        }
        return $this->interfaces[$key];
    }

    public function __set(string $key, $value): void
    {
        if (array_key_exists($key, $this->interfaces)) {
            throw new \Exception("$key already exists in the container", 1);
        }
        $this->interfaces[$key] = $value;
    }
}
