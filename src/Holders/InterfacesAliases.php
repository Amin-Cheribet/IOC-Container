<?php

namespace IOC\Holders;

class InterfacesAliases implements RegisteryHolder
{
    private $interfaces = [];

    public function __get(string $key): string
    {
        return $this->interfaces[$key];
    }

    public function __set(string $key, string $value): void
    {
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
