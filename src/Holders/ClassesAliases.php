<?php

namespace IOC\Holders;

class ClassesAliases implements RegisteryHolder
{
    private $classes = [];

    public function __get(string $key): string
    {
        return $this->classes[$key];
    }

    public function __set(string $key, string $value): void
    {
        $this->classes[$key] = $value;
    }

    public function __isset(string $key): bool
    {
        if (isset($this->classes[$key])) {
            return true;
        }
        return false;
    }
}
