<?php

namespace IOC\ClassFinder;

use IOC\Holders\RegistryHolder as RegistryHolder;

class TypeFinder implements FinderInterface
{
    public function __construct(
        private readonly RegistryHolder $holder,
    ) {}

    public function find(string $className): bool
    {
        if (isset($this->holder->{$className})) {
            return true;
        }

        return false;
    }
}
