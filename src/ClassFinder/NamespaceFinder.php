<?php

namespace IOC\ClassFinder;

use IOC\Holders\RegistryHolder as RegistryHolder;

class NamespaceFinder implements NamespaceFinderInterface
{
    private string $className;
    private RegistryHolder $classesHolder;
    private RegistryHolder $typesHolder;

    public function __construct(string $className, RegistryHolder $classesHolder, RegistryHolder $typesHolder)
    {
        $this->className = $className;
        $this->classesHolder = $classesHolder;
        $this->typesHolder = $typesHolder;
    }

    public function getRealClassName(): string
    {
        if (class_exists($this->className)) {
            return $this->className;
        }
        if ($this->inHolder(new ClassFinder($this->classesHolder))) {
            return $this->classesHolder->{$this->className};
        }
        if ($this->inHolder(new TypeFinder($this->typesHolder))) {
            return $this->typesHolder->{$this->className};
        }

        throw new \Exception("$this->className can't be found", 1);
    }

    private function inHolder(FinderInterface $finder): bool
    {
        return $finder->find($this->className);
    }
}
