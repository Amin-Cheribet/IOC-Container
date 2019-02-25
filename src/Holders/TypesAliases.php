<?php

namespace IOC\Holders;

class TypesAliases implements RegisteryHolder
{
    private $interfaces = [];

    public function __get(string $key): string
    {
        return $this->interfaces[$key];
    }

    public function __set(string $key, string $value): void
    {
        if (isset($this->interfaces[$key])) {
            throw new \Exception("Can't register $key type, already registered in the container", 1);
        }
        $this->interfaces[$key] = $value;
    }

    public function __isset(string $key): bool
    {
        if (isset($this->interfaces[$key])) {
            return true;
        }
        return false;
    }
}
