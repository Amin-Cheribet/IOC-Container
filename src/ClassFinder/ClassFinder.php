<?php

namespace IOC\ClassFinder;

use IOC\Holders\RegistryHolder as RegistryHolder;

class ClassFinder implements FinderInterface
{
    private RegistryHolder $holder;

    public function __construct(RegistryHolder $holder)
    {
        $this->holder = $holder;
    }

    public function find(string $className): bool
    {
        if (isset($this->holder->{$className})) {
            return true;
        }

        return false;
    }
}
