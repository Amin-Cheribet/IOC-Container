<?php
namespace IOC\ClassFinder;

class ClassTypeFinder implements FinderInterface
{
    private $holder;

    public function __construct(RegisteryHolder $holder)
    {
        $this->holder = $holder;
    }

    public function find(string $className): boolean
    {
        if (isset($this->holder->{$className})) {
            return true;
        }
        return false;
    }
}
