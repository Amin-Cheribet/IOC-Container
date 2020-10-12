<?php
namespace IOC\ClassFinder;

use IOC\Holders\RegisteryHolder;

class ClassFinder implements FinderInterface
{
    private $holder;

    public function __construct(RegisteryHolder $holder)
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
