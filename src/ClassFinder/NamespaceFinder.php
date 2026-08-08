<?php

namespace IOC\ClassFinder;

use IOC\Holders\RegistryHolder as RegistryHolder;

class NamespaceFinder implements NamespaceFinderInterface
{
    public function __construct(
        private readonly string $className,
        private readonly RegistryHolder $classesHolder,
        private readonly RegistryHolder $typesHolder,
    ) {}

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
